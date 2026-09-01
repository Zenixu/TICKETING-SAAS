<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Show form submit bukti bayar (untuk attendee).
     * Hanya bisa diakses jika attendee memiliki status pending_payment.
     */
    public function submitForm(Request $request, Attendee $attendee)
    {
        // Attendee hanya boleh akses tiket miliknya sendiri
        if ($attendee->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        if ($attendee->status !== 'pending_payment') {
            return redirect()->route('my-tickets')
                ->with('error', 'Tiket ini tidak dalam status menunggu pembayaran.');
        }

        $event = $attendee->event;
        return view('payment.submit', compact('attendee', 'event'));
    }

    /**
     * Submit bukti bayar oleh attendee.
     */
    public function submitProof(Request $request, Attendee $attendee)
    {
        if ($attendee->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        if ($attendee->status !== 'pending_payment') {
            return back()->with('error', 'Status tiket tidak memungkinkan submit bukti.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_name' => 'required|string|max:100',
            'account_holder_name' => 'nullable|string|max:255',
            'transfer_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
        ]);

        // Simpan gambar
        $imagePath = $request->file('image')->store('payment-proofs', 'public');

        // Hapus payment proof lama jika ada (misal: attendee submit ulang setelah ditolak)
        if ($attendee->paymentProof) {
            Storage::disk('public')->delete($attendee->paymentProof->image_path);
            $attendee->paymentProof->delete();
        }

        // Buat payment proof baru
        PaymentProof::create([
            'attendee_id' => $attendee->id,
            'amount' => $validated['amount'],
            'bank_name' => $validated['bank_name'],
            'account_holder_name' => $validated['account_holder_name'] ?? null,
            'transfer_date' => $validated['transfer_date'],
            'notes' => $validated['notes'] ?? null,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        // Update attendee status
        $attendee->update(['status' => 'pending_verification']);

        return redirect()->route('my-tickets')
            ->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu verifikasi dari penyelenggara.');
    }

    /**
     * Halaman verifikasi pembayaran oleh organizer.
     */
    public function verifications(Request $request, Event $event)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $filter = $request->query('status', 'pending_verification');

        $query = $event->attendees()
            ->whereIn('status', ['pending_verification', 'registered'])
            ->with('paymentProof', 'user')
            ->orderByDesc('created_at');

        if (in_array($filter, ['pending_verification', 'registered'], true)) {
            $query->where('status', $filter);
        }

        $attendees = $query->get();

        $counts = [
            'all' => $event->attendees()->whereIn('status', ['pending_verification', 'registered'])->count(),
            'pending_verification' => $event->attendees()->where('status', 'pending_verification')->count(),
            'registered' => $event->attendees()->where('status', 'registered')->count(),
            'pending_payment' => $event->attendees()->where('status', 'pending_payment')->count(),
        ];

        return view('organizer.payments', compact('event', 'attendees', 'filter', 'counts'));
    }

    /**
     * Approve bukti pembayaran oleh organizer.
     */
    public function verify(Request $request, Event $event, Attendee $attendee)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        if ($attendee->event_id !== $event->id) {
            abort(404, 'Attendee tidak terkait dengan event ini.');
        }

        if ($attendee->status !== 'pending_verification') {
            return back()->with('error', 'Hanya tiket berstatus verifikasi yang bisa di-approve.');
        }

        if (!$attendee->paymentProof) {
            return back()->with('error', 'Bukti pembayaran tidak ditemukan.');
        }

        // Update payment proof
        $attendee->paymentProof->update([
            'status' => 'verified',
            'verified_by' => $user->id,
            'verified_at' => now(),
        ]);

        // Update attendee
        $attendee->update(['status' => 'registered']);

        return back()->with('success', "✓ Pembayaran diverifikasi: {$attendee->name} sekarang Teregistrasi.");
    }

    /**
     * Reject bukti pembayaran oleh organizer.
     */
    public function reject(Request $request, Event $event, Attendee $attendee)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        if ($attendee->event_id !== $event->id) {
            abort(404, 'Attendee tidak terkait dengan event ini.');
        }

        if ($attendee->status !== 'pending_verification') {
            return back()->with('error', 'Hanya tiket berstatus verifikasi yang bisa di-reject.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:5|max:500',
        ]);

        if ($attendee->paymentProof) {
            $attendee->paymentProof->update([
                'status' => 'rejected',
                'verified_by' => $user->id,
                'verified_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);
        }

        // Kembalikan ke pending_payment agar bisa submit ulang
        $attendee->update(['status' => 'pending_payment']);

        return back()->with('warning', "Bukti pembayaran ditolak: {$attendee->name}. Pesan telah dikirim ke peserta.");
    }
}
