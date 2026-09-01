<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventRegistrationController extends Controller
{
    /**
     * Daftarkan user login sebagai attendee event.
     * Event gratis → status 'registered' (langsung confirmed).
     * Event berbayar → status 'pending_payment' (menunggu approval organizer).
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validasi event aktif
        if ($event->status !== 'active') {
            return back()->with('error', 'Event ini sudah tidak tersedia untuk pendaftaran.');
        }

        // 2. Validasi event belum lewat
        if ($event->date_time->isPast()) {
            return back()->with('error', 'Event ini sudah lewat, tidak bisa didaftar.');
        }

        $user = $request->user();

        // 3. Cegah organizer daftar event-nya sendiri
        if ($event->user_id === $user->id) {
            return back()->with('error', 'Anda tidak bisa mendaftar di event Anda sendiri.');
        }

        // 4. Cegah duplikat pendaftaran
        $exists = Attendee::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['registered', 'checked_in', 'pending_payment'])
            ->exists();
        if ($exists) {
            return back()->with('info', 'Anda sudah terdaftar di event ini.');
        }

        // 5. Validasi kuota
        $currentCount = Attendee::where('event_id', $event->id)
            ->whereIn('status', ['registered', 'checked_in', 'pending_payment'])
            ->count();
        if ($currentCount >= $event->quota) {
            return back()->with('error', 'Kuota event sudah penuh. Silakan pilih event lain.');
        }

        // 6. Validasi form
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|min:10|max:20|regex:/^[0-9+\-\s]+$/',
            'payment_proof' => 'nullable|url',
        ]);

        // 7. Tentukan status: free → registered, paid → pending_payment
        $status = $event->price > 0 ? 'pending_payment' : 'registered';

        // 8. Buat attendee
        $attendee = Attendee::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'qr_code_token' => Str::random(40),
            'status' => $status,
        ]);

        // 9. Kalau event berbayar & ada payment_proof URL, buat record EventPayment pending
        if ($event->price > 0 && !empty($validated['payment_proof'])) {
            $event->payment()->create([
                'transaction_id' => 'MANUAL_' . strtoupper(Str::random(10)),
                'amount' => $event->price,
                'payment_status' => 'pending',
            ]);
        }

        // 10. Redirect ke halaman sukses
        return redirect()->route('events.success', [
            'event' => $event->id,
            'attendee' => $attendee->id,
        ])->with('success', $status === 'pending_payment'
            ? 'Pendaftaran berhasil! Mohon tunggu konfirmasi pembayaran dari organizer.'
            : 'Pendaftaran berhasil! Tiket Anda sudah aktif.');
    }

    /**
     * Halaman sukses setelah registrasi — tampilkan QR code & detail tiket.
     */
    public function success(Request $request, Event $event, Attendee $attendee)
    {
        // Pastikan attendee milik user yang sedang login & sesuai event
        if ($attendee->user_id !== $request->user()->id || $attendee->event_id !== $event->id) {
            abort(403, 'Tiket ini bukan milik Anda.');
        }

        return view('events.success', compact('event', 'attendee'));
    }

    /**
     * Halaman "Tiket Saya" — list semua tiket milik user login.
     */
    public function myTickets(Request $request)
    {
        $user = $request->user();
        $attendees = Attendee::with('event')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('my-tickets', compact('attendees'));
    }
}
