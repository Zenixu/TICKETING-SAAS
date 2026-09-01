<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizerRequestController extends Controller
{
    /**
     * User biasa mengajukan permintaan menjadi Organizer Event.
     */
    public function request()
    {
        $user = auth()->user();

        if ($user->role === 'organizer' || $user->role === 'admin') {
            return back()->with('info', 'Anda sudah memiliki wewenang untuk membuat event.');
        }

        $user->update([
            'organizer_status' => 'pending'
        ]);

        $adminWaNumber = '6282114073679';
        $message = urlencode("Halo Admin LoketKita, saya {$user->name} ({$user->email}) telah mengajukan permintaan untuk menjadi Event Organizer di platform LoketKita. Mohon informasi lebih lanjut terkait persetujuannya.");
        $waLink = "https://wa.me/{$adminWaNumber}?text={$message}";

        return redirect()->away($waLink);
    }
}
