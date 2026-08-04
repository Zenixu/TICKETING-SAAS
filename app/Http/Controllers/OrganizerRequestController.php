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

        return back()->with('success', 'Pengajuan Anda sebagai Organizer berhasil dikirim! Menunggu persetujuan Admin.');
    }
}
