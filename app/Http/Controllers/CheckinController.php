<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckinController extends Controller
{
    /**
     * Tampilkan list attendees per event dengan filter status & search.
     */
    public function attendees(Request $request, Event $event)
    {
        // Authorization: organizer hanya boleh akses event miliknya, admin bebas
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $filter = $request->query('status', 'all');
        $search = trim((string) $request->query('q', ''));

        $query = $event->attendees()->orderByDesc('created_at');

        if (in_array($filter, ['registered', 'checked_in', 'pending_payment', 'cancelled'], true)) {
            $query->where('status', $filter);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $attendees = $query->get();

        // Counters untuk tab filter
        $counts = [
            'all' => $event->attendees()->count(),
            'registered' => $event->attendees()->where('status', 'registered')->count(),
            'checked_in' => $event->attendees()->where('status', 'checked_in')->count(),
            'pending_payment' => $event->attendees()->where('status', 'pending_payment')->count(),
            'cancelled' => $event->attendees()->where('status', 'cancelled')->count(),
        ];

        return view('organizer.attendees', compact('event', 'attendees', 'filter', 'search', 'counts'));
    }

    /**
     * Tampilkan halaman scanner (input manual token QR).
     */
    public function scanPage(Request $request, Event $event)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        // Stats real-time
        $stats = [
            'registered' => $event->attendees()->where('status', 'registered')->count(),
            'checked_in' => $event->attendees()->where('status', 'checked_in')->count(),
            'pending' => $event->attendees()->where('status', 'pending_payment')->count(),
            'total' => $event->attendees()->count(),
        ];
        $stats['quota'] = $event->quota;
        $stats['remaining_quota'] = max(0, $event->quota - $stats['total']);

        // History scan: 5 terakhir (dari session)
        $history = Session::get('scan_history.' . $event->id, []);

        return view('organizer.scan', compact('event', 'stats', 'history'));
    }

    /**
     * Process scan: validasi token, update status, set flash + history.
     */
    public function processScan(Request $request, Event $event)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $request->validate([
            'qr_code_token' => 'required|string|min:8',
        ]);

        $token = trim($request->input('qr_code_token'));
        $attendee = Attendee::where('qr_code_token', $token)->first();

        // Result type: 'success' | 'invalid' | 'wrong_event' | 'unpaid' | 'duplicate' | 'cancelled'
        $result = ['type' => 'invalid', 'message' => 'Token tidak valid atau tidak ditemukan.'];

        if (!$attendee) {
            // Token tidak ditemukan di DB
            $result = ['type' => 'invalid', 'message' => 'QR Code tidak dikenali. Pastikan token benar.'];
        } elseif ($attendee->event_id !== $event->id) {
            $result = [
                'type' => 'wrong_event',
                'message' => "Token ini milik event: \"{$attendee->event->title}\", bukan event ini.",
            ];
        } elseif ($attendee->status === 'cancelled') {
            $result = [
                'type' => 'cancelled',
                'message' => "Tiket \"{$attendee->name}\" sudah dibatalkan.",
                'attendee' => $attendee,
            ];
        } elseif ($attendee->status === 'pending_payment') {
            $result = [
                'type' => 'unpaid',
                'message' => "Tiket \"{$attendee->name}\" belum lunas. Tidak bisa check-in.",
                'attendee' => $attendee,
            ];
        } elseif ($attendee->status === 'checked_in') {
            $checkedAt = $attendee->checked_in_at ? $attendee->checked_in_at->translatedFormat('d M Y · H:i') : '—';
            $result = [
                'type' => 'duplicate',
                'message' => "\"{$attendee->name}\" sudah check-in sejak {$checkedAt}.",
                'attendee' => $attendee,
            ];
        } elseif ($attendee->status === 'registered') {
            // Sukses! Update status
            $attendee->update([
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);
            $result = [
                'type' => 'success',
                'message' => "✓ Check-in berhasil: {$attendee->name}",
                'attendee' => $attendee,
            ];
        }

        // Simpan ke history (5 terakhir per event)
        $history = Session::get('scan_history.' . $event->id, []);
        array_unshift($history, [
            'time' => now()->format('H:i:s'),
            'type' => $result['type'],
            'message' => $result['message'],
            'token' => substr($token, 0, 8) . '…',
        ]);
        $history = array_slice($history, 0, 5);
        Session::put('scan_history.' . $event->id, $history);

        // Flash message untuk next render
        $flashType = match ($result['type']) {
            'success' => 'success',
            'duplicate' => 'warning',
            default => 'error',
        };
        session()->flash($flashType, $result['message']);

        return redirect()->route('organizer.events.scan', $event);
    }

    /**
     * Manual check-in per attendee (untuk kasus khusus: attendee lupa QR).
     */
    public function manualCheckIn(Request $request, Event $event, Attendee $attendee)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        if ($attendee->event_id !== $event->id) {
            abort(404, 'Attendee tidak terkait dengan event ini.');
        }

        if (!$attendee->canCheckIn()) {
            $msg = match ($attendee->status) {
                'checked_in' => 'Attendee sudah check-in sebelumnya.',
                'pending_payment' => 'Attendee belum melunasi pembayaran.',
                'cancelled' => 'Tiket sudah dibatalkan.',
                default => 'Status tidak memungkinkan check-in.',
            };
            return back()->with('error', $msg);
        }

        $attendee->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        return back()->with('success', "Manual check-in berhasil: {$attendee->name}");
    }
}
