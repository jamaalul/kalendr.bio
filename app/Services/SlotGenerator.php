<?php

namespace App\Services;

use App\Models\EventType;
use App\Models\Booking;
use App\Models\Exception;
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

        // Preload exception datetime ranges for the user
        $exceptions = Exception::where('user_id', $eventType->user_id)
            ->where(function ($q) use ($from, $to) {
                // Find exceptions that overlap with the requested range
                $q->whereBetween('start_datetime', [$from, $to])
                    ->orWhereBetween('end_datetime', [$from, $to])
                    ->orWhere(function ($q2) use ($from, $to) {
                        $q2->where('start_datetime', '<', $from)->where('end_datetime', '>', $to);
                    });
            })->get();

        // Preload existing bookings for the user in the UTC window (cover entire period)
        $existingBookings = Booking::whereHas('eventType', function ($q) use ($eventType) {
            $q->where('user_id', $eventType->user_id);
        })
            ->whereIn('status', ['scheduled', 'accepted', 'proposed'])
            ->where(function ($q) use ($from, $to) {
                // Buffer the range slightly to catch bookings that might overlap via padding
                $q->whereBetween('starts_at', [$from->copy()->subMinutes(120), $to->copy()->addMinutes(120)])
                    ->orWhereBetween('ends_at', [$from->copy()->subMinutes(120), $to->copy()->addMinutes(120)])
                    ->orWhere(function ($q2) use ($from, $to) {
                        $q2->where('starts_at', '<', $from)->where('ends_at', '>', $to);
                    });
            })->get();

        $minimumNotice = $eventType->minimum_notice_minutes ?? 0;
        $beforePadding = $eventType->before_slot_padding_minutes ?? 0;
        $afterPadding = $eventType->after_slot_padding_minutes ?? 0;

        // Current time for notice check - ALWAYS USE UTC
        $nowUtc = Carbon::now('UTC');
        $earliestPossibleStartUtc = $nowUtc->copy()->addMinutes($minimumNotice);

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

                while ($slotStart->copy()->lte($endDateTime->copy()->subMinutes($duration))) {
                    $slotEnd = $slotStart->copy()->addMinutes($duration);

                    // Convert slot to UTC for storage/comparison
                    $slotStartUtc = $slotStart->copy()->setTimezone('UTC');
                    $slotEndUtc = $slotEnd->copy()->setTimezone('UTC');

                    // 1. Check Minimum Notice (against UTC)
                    if ($slotStartUtc->lt($earliestPossibleStartUtc)) {
                        // If it's too early, move forward. Using duration as a safe step.
                        $slotStart->addMinutes($duration); 
                        continue;
                    }

                    // 2. Check if slot in global requested range (use UTC boundaries)
                    if ($slotEndUtc->lt($from->copy()->setTimezone('UTC')) || $slotStartUtc->gt($to->copy()->setTimezone('UTC'))) {
                        $slotStart->addMinutes($duration);
                        continue;
                    }

                    // 3. Check overlap with exceptions (datetime ranges)
                    $overlapsException = $exceptions->first(function ($exc) use ($slotStartUtc, $slotEndUtc) {
                        return $slotStartUtc->lt($exc->end_datetime) && $slotEndUtc->gt($exc->start_datetime);
                    });

                    if ($overlapsException) {
                        $step = min($duration, 15);
                        $slotStart->addMinutes($step);
                        continue;
                    }

                    // 4. Check overlap with existing bookings (in UTC)
                    // We need to account for padding around the slot we're trying to place
                    $paddedSlotStartUtc = $slotStartUtc->copy()->subMinutes($beforePadding);
                    $paddedSlotEndUtc = $slotEndUtc->copy()->addMinutes($afterPadding);

                    $overlaps = $existingBookings->first(function ($b) use ($paddedSlotStartUtc, $paddedSlotEndUtc) {
                        return $b->starts_at->lt($paddedSlotEndUtc) && $b->ends_at->gt($paddedSlotStartUtc);
                    });

                    if (!$overlaps) {
                        $slots->push([
                            'starts_at_utc' => $slotStartUtc->copy(),
                            'ends_at_utc' => $slotEndUtc->copy(),
                            'starts_at_event_tz' => $slotStart->copy(),
                            'ends_at_event_tz' => $slotEnd->copy(),
                        ]);
                    }

                    // Move to next potential slot. 
                    // To ensure gaps, we jump by (duration + 1 minute) at least.
                    // But if we want back-to-back available slots to ALREADY respect padding,
                    // then Slot 2 should start at Slot 1 End + AfterPadding + BeforePadding.
                    // However, that might be too aggressive if the host wants slots every 15m.
                    // Let's stick to a small step (e.g. 15m if duration > 15, or duration) 
                    // OR just move by a fixed interval like 15 or 30 mins to show more options.
                    // For now, let's use 15 minutes as a common "slot granularity" or duration.
                    $step = min($duration, 15);
                    $slotStart->addMinutes($step);
                }
            }

            $cursor->addDay();
        }

        // Optionally sort and return
        return $slots->sortBy('starts_at_utc')->values();
    }
}
