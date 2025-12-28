<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventType;
use App\Services\SlotGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function show($username, $eventTypeSlug, SlotGenerator $slotGenerator, Request $request)
    {
        $user = User::where('username', $username)->firstOrFail();

        $eventType = EventType::where('user_id', $user->id)
            ->where('slug', $eventTypeSlug)
            ->where('is_active', true)
            ->with('eventTypeAvailabilities')
            ->firstOrFail();

        // define the window to show (e.g., next 14 days)
        $from = Carbon::now(); // viewer's local tz not needed here for generation
        $to = Carbon::now()->addDays(28);

        $slots = $slotGenerator->generate($eventType, $from, $to);

        // Convert slot times to viewer tz for display
        $viewerTz = $request->query('timezone') ?? $request->cookie('viewer_timezone') ?? $request->session()->get('viewer_timezone') ?? $eventType->timezone;
        
        // Validate timezone
        try {
            new \DateTimeZone($viewerTz);
        } catch (\Exception $e) {
            $viewerTz = $eventType->timezone;
        }

        $displaySlots = $slots->map(function ($s) use ($viewerTz) {
            return [
                'starts_at_utc' => $s['starts_at_utc'],
                'ends_at_utc' => $s['ends_at_utc'],
                'starts_at_viewer' => $s['starts_at_utc']->copy()->setTimezone($viewerTz),
                'ends_at_viewer' => $s['ends_at_utc']->copy()->setTimezone($viewerTz),
            ];
        });


        $timezones = [
            'Asia/Jakarta' => 'Waktu Indonesia Barat (WIB)',
            'Asia/Makassar' => 'Waktu Indonesia Tengah (WITA)',
            'Asia/Jayapura' => 'Waktu Indonesia Timur (WIT)',
        ];

        return view('booking.show', compact('eventType', 'displaySlots', 'viewerTz', 'timezones'));
    }

    /**
     * Book a slot. This must be safe against concurrent bookings.
     */
    public function book($username, $eventTypeSlug, Request $request)
    {
        $user = User::where('username', $username)->firstOrFail();

        $eventType = EventType::where('user_id', $user->id)
            ->where('slug', $eventTypeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'starts_at_utc' => 'required|date', // ISO-ish in UTC
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_timezone' => 'nullable|string',
        ]);

        // parse incoming UTC times
        $startsAtUtc = Carbon::parse($data['starts_at_utc'], 'UTC');
        $endsAtUtc = $startsAtUtc->copy()->addMinutes($eventType->duration_minutes);

        // Transaction + overlap check
        $booking = DB::transaction(function () use ($eventType, $startsAtUtc, $endsAtUtc, $data) {
            // Check concurrent overlap again with db
            $overlap = Booking::where('event_type_id', $eventType->id)
                ->where('status', 'scheduled')
                ->where(function ($q) use ($startsAtUtc, $endsAtUtc) {
                    $q->where('starts_at', '<', $endsAtUtc)
                        ->where('ends_at', '>', $startsAtUtc);
                })
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                return null;
            }

            // Create booking in UTC
            return Booking::create([
                'event_type_id' => $eventType->id,
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_timezone' => $data['guest_timezone'] ?? null,
                'starts_at' => $startsAtUtc,
                'ends_at' => $endsAtUtc,
                'status' => 'scheduled',
            ]);
        });

        if (!$booking) {
            return back()->withErrors(['slot' => 'Slot just got booked by someone else. Please pick another time.']);
        }

        // send emails/notifications (queue later)
        // Mail::to($booking->guest_email)->send(...);
        // notify host...

        return redirect()->route('booking.confirmation', [$user->username, $eventType->slug, 'booking' => $booking->id]);
    }

    public function confirmation($username, $eventTypeSlug, Booking $booking)
    {
        $booking->load(['eventType.user']);

        // Simple security check: ensure booking belongs to the event type url
        if ($booking->eventType->slug !== $eventTypeSlug || $booking->eventType->user->username !== $username) {
            abort(404);
        }

        return view('booking.confirmation', compact('booking'));
    }
}
