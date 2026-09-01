<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class WebEventController extends Controller
{
    /**
     * Tampilkan halaman dashboard organizer.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'admin') {
            // Admin bisa melihat semua event
            $events = Event::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            // Organizer hanya melihat miliknya sendiri
            $events = Event::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }
        
        $totalEvents = $events->count();
        $totalAttendees = 0;

        // Counter breakdown per event
        $attendeeCounts = [];
        foreach ($events as $event) {
            $counts = [
                'registered' => $event->attendees()->where('status', 'registered')->count(),
                'checked_in' => $event->attendees()->where('status', 'checked_in')->count(),
                'pending_payment' => $event->attendees()->where('status', 'pending_payment')->count(),
                'cancelled' => $event->attendees()->where('status', 'cancelled')->count(),
            ];
            $counts['total'] = array_sum($counts);
            $attendeeCounts[$event->id] = $counts;
            $totalAttendees += $counts['total'];
        }

        return view('dashboard', compact('events', 'totalEvents', 'totalAttendees', 'attendeeCounts'));
    }

    /**
     * Simpan event baru dari dashboard.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_time' => 'required|date',
            'location_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'banner_path' => 'nullable|url',
            'category' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'custom_services' => 'nullable|array',
        ]);

        $event = Event::create([
            'user_id' => $request->user()->id,
            'status' => 'active', // Langsung aktif
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date_time' => $validated['date_time'],
            'location_name' => $validated['location_name'],
            'price' => $validated['price'],
            'quota' => $validated['quota'],
            'banner_path' => $validated['banner_path'] ?? null,
            'category' => $validated['category'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'bank_account' => $validated['bank_account'] ?? null,
            'custom_services' => isset($validated['custom_services']) ? $validated['custom_services'] : null,
        ]);

        return back()->with('success', 'Event berhasil dibuat! Cek di landing page.');
    }

    /**
     * Hapus event.
     */
    public function destroy(Request $request, Event $event)
    {
        $user = $request->user();

        // Hanya admin atau pemilik event yang boleh menghapus
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda hanya dapat menghapus event milik Anda sendiri.');
        }

        $event->delete();

        return back()->with('success', 'Event berhasil dihapus.');
    }
}
