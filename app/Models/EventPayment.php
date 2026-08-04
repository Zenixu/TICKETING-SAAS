<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventPayment extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'transaction_id',
        'amount',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the event associated with this payment.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
