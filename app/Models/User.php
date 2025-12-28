<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'timezone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function eventTypes()
    {
        return $this->hasMany(EventType::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class,
            EventType::class,
            'user_id',       // Foreign key on event_types table
            'event_type_id', // Foreign key on bookings table
            'id',            // Local key on users table
            'id'             // Local key on event_types table
        );
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->username)) {
                $base = Str::slug($user->name);
                $user->username = static::generateUniqueUsername($base);
            }
        });
    }

    protected static function generateUniqueUsername(string $base): string
    {
        $username = $base;
        $counter = 1;

        while (static::where('username', $username)->exists()) {
            $username = $base . '-' . $counter;
            $counter++;
        }

        return $username;
    }
}
