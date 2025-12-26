<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventTypeAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */
    
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}
