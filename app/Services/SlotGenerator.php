<?php

namespace App\Services;

use App\Models\EventType;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class SlotGenerator
{
    /**
     * Generate available slots for an EventType between $from and $to (both Carbon).
     *
     * Return an array or collection of slots with:
     *  - starts_at (Carbon in UTC)
     *  - ends_at (Carbon in UTC)
     *  - starts_at_local (Carbon in viewer tz) -> for display, handled at controller/view
     */
    public function generate(EventType $eventType, Carbon $from, Carbon $to, string $viewerTz = null): Collection
    {
        // Normalize the range (use eventType timezone for slicing)
        $eventTz = $eventType->timezone ?? 'UTC';

        // Convert boundaries into event timezone to check day_of_week and times
        $fromInEventTz = $from->copy()->setTimezone($eventTz)->startOfDay();
        $toInEventTz = $to->copy()->setTimezone($eventTz)->endOfDay();

        $duration = $eventType->duration_minutes;

        $slots = collect();

        // Load availabilities once
        $availabilities = $eventType->eventTypeAvailabilities; // collection of EventTypeAvailability

        // Preload existing bookings for the event in the UTC window (cover entire period)
        $existingBookings = Booking::where('event_type_id', $eventType->id)
            ->where('status', 'scheduled')
            ->where(function ($q) use ($from, $to) {
                $q->whereBetween('starts_at', [$from->copy()->subMinutes(1), $to->copy()->addMinutes(1)])
                    ->orWhereBetween('ends_at', [$from->copy()->subMinutes(1), $to->copy()->addMinutes(1)])
                    ->orWhere(function ($q2) use ($from, $to) {
                        $q2->where('starts_at', '<', $from)->where('ends_at', '>', $to);
                    });
            })->get();

        // iterate day-by-day in event timezone
        $cursor = $fromInEventTz->copy();
        while ($cursor->lte($toInEventTz)) {
            $dow = (int)$cursor->dayOfWeek; // 0..6 (Sunday..Saturday)

            // find availabilities for dow
            $dayAvailabilities = $availabilities->where('day_of_week', $dow);

            foreach ($dayAvailabilities as $av) {
                // Build start/end Carbon in event timezone for that date
                $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $cursor->format('Y-m-d') . ' ' . $av->start_time, $eventTz);
                $endDateTime   = Carbon::createFromFormat('Y-m-d H:i', $cursor->format('Y-m-d') . ' ' . $av->end_time, $eventTz);

                if ($endDateTime->lte($startDateTime)) {
                    // skip invalid range
                    continue;
                }

                // iterate slots in this window
                $slotStart = $startDateTime->copy();

                while ($slotStart->addMinutes(0)->lte($endDateTime->copy()->subMinutes($duration))) {
                    $slotEnd = $slotStart->copy()->addMinutes($duration);

                    // Convert slot to UTC for storage/comparison
                    $slotStartUtc = $slotStart->copy()->setTimezone('UTC');
                    $slotEndUtc = $slotEnd->copy()->setTimezone('UTC');

                    // Check if slot in global requested range (use UTC boundaries)
                    if ($slotEndUtc->lt($from->copy()->setTimezone('UTC')) || $slotStartUtc->gt($to->copy()->setTimezone('UTC'))) {
                        // outside requested UTC window
                        $slotStart->addMinutes($duration);
                        continue;
                    }

                    // Check overlap with existing bookings (in UTC)
                    $overlaps = $existingBookings->first(function ($b) use ($slotStartUtc, $slotEndUtc) {
                        return $b->starts_at->lt($slotEndUtc) && $b->ends_at->gt($slotStartUtc);
                    });

                    if (!$overlaps) {
                        $slots->push([
                            'starts_at_utc' => $slotStartUtc->copy(),
                            'ends_at_utc' => $slotEndUtc->copy(),
                            // include event tz instance if you want to display in event timezone
                            'starts_at_event_tz' => $slotStart->copy(),
                            'ends_at_event_tz' => $slotEnd->copy(),
                        ]);
                    }

                    $slotStart->addMinutes($duration);
                }
            }

            $cursor->addDay();
        }

        // Optionally sort and return
        return $slots->sortBy('starts_at_utc')->values();
    }
}
