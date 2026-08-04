<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan Dashboard Admin utama (Konsol Manajemen).
     */
    public function index()
    {
        $usersCount = User::count();
        $eventsCount = Event::count();
        $pendingOrganizers = User::where('organizer_status', 'pending')->get();
        $allUsers = User::latest()->paginate(10);

        return view('admin.index', compact('usersCount', 'eventsCount', 'pendingOrganizers', 'allUsers'));
    }

    /**
     * Menyetujui pengajuan User biasa menjadi Organizer.
     */
    public function approveOrganizer(User $user)
    {
        $user->update([
            'role' => 'organizer',
            'organizer_status' => 'approved'
        ]);

        return back()->with('success', "Akun {$user->name} kini resmi menjadi Organizer Event.");
    }

    /**
     * Menolak pengajuan User biasa menjadi Organizer.
     */
    public function rejectOrganizer(User $user)
    {
        $user->update([
            'organizer_status' => 'rejected'
        ]);

        return back()->with('success', "Pengajuan akun {$user->name} telah ditolak.");
    }

    /**
     * Mengubah Role User secara manual oleh Admin.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|in:user,organizer,admin',
        ]);

        $user->update([
            'role' => $validated['role']
        ]);

        return back()->with('success', "Role akun {$user->name} berhasil diubah menjadi: " . strtoupper($validated['role']));
    }
}
