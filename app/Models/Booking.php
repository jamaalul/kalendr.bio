<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'event_type_id',
        'guest_name',
        'guest_email',
        'guest_timezone',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}
