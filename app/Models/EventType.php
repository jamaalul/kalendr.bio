<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'duration_minutes',
        'minimum_notice_minutes',
        'before_slot_padding_minutes',
        'after_slot_padding_minutes',
        'timezone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventTypeAvailabilities()
    {
        return $this->hasMany(EventTypeAvailability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /*
     |--------------------------------------------------------------------------
     | Model Hooks
     |--------------------------------------------------------------------------
     */

    protected static function booted()
    {
        static::creating(function (EventType $eventType) {
            if (empty($eventType->slug)) {
                $eventType->slug = static::generateUniqueSlug(
                    $eventType->name,
                    $eventType->user_id
                );
            }
        });
    }

    /*
     |--------------------------------------------------------------------------
     | Helpers
     |--------------------------------------------------------------------------
     */

    public static function generateUniqueSlug(string $name, int $userId): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            static::where('user_id', $userId)
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}
