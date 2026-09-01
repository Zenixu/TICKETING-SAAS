<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attendee extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone_number',
        'qr_code_token',
        'status',
        'checked_in_at',
        'notes',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    /**
     * Get the event the attendee is registered for.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user (end-user) who registered for this ticket.
     * Nullable: guest registration via seeder/admin may not have user_id.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the feedback for the attendee.
     */
    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }

    /**
     * Get the payment proof submitted by the attendee.
     */
    public function paymentProof(): HasOne
    {
        return $this->hasOne(PaymentProof::class);
    }

    /**
     * Get the latest payment proof (alias untuk paymentProof yang lebih konsisten dengan hasOne).
     */
    public function latestPaymentProof(): HasOne
    {
        return $this->hasOne(PaymentProof::class)->latestOfMany();
    }

    /**
     * Check if this attendee is allowed to check in.
     * Strict gate: only 'registered' (paid & confirmed) may check in.
     * 'pending_payment' and 'cancelled' are blocked.
     */
    public function canCheckIn(): bool
    {
        return $this->status === 'registered';
    }

    /**
     * Human-readable status label.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'registered' => 'Terdaftar',
            'checked_in' => 'Sudah Check-in',
            'pending_payment' => 'Menunggu Bayar',
            'pending_verification' => 'Verifikasi Bukti',
            'cancelled' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    /**
     * Status color class for badge (Tailwind).
     */
    public function statusColor(): string
    {
        return match ($this->status) {
            'registered' => 'mint',
            'checked_in' => 'mint',
            'pending_payment' => 'coral',
            'pending_verification' => 'coral',
            'cancelled' => 'text-muted',
            default => 'text-muted',
        };
    }
}
