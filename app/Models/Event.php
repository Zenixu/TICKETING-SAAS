<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date_time',
        'google_calendar_event_id',
        'location_name',
        'latitude',
        'longitude',
        'status',
        'certificate_template_path',
        'material_links',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'material_links' => 'json',
    ];

    /**
     * Get the organizer that owns the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment details for the event.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(EventPayment::class);
    }

    /**
     * Get the attendees registered for the event.
     */
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
