<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Feedback extends Model
{
    use HasUuids;

    protected $fillable = [
        'attendee_id',
        'rating',
        'review',
    ];
}
