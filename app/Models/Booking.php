<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'event_type_id',
        'cancel_token',
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

    protected static function booted()
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->cancel_token)) {
                $booking->cancel_token = static::generateUniqueCancelToken();
            }
        });
    }

    public static function generateUniqueCancelToken(): string
    {
        // 48 chars is strong; adjust if you prefer UUID
        do {
            $token = Str::random(48);
        } while (static::where('cancel_token', $token)->exists());

        return $token;
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function isCancelled(): bool
    {
        return in_array($this->status, ['cancelled', 'cancellation_requested']);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancellationRequested(): bool
    {
        return $this->status === 'cancellation_requested';
    }

    public function canBeCancelledByGuest(): bool
    {
        return in_array($this->status, ['proposed', 'accepted']);
    }
}
