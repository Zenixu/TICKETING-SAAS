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
        'name',
        'email',
        'qr_code_token',
        'status',
        'checked_in_at',
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
     * Get the feedback for the attendee.
     */
    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }
}
