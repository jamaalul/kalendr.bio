Hi {{ $booking->guest_name }},

Your booking has been confirmed.

Event: {{ $booking->eventType->name }}
Host: {{ $booking->eventType->user->name }}

Date: {{ $booking->starts_at
    ->setTimezone($booking->guest_timezone)
    ->format('D, d M Y') }}

Time: {{ $booking->starts_at
    ->setTimezone($booking->guest_timezone)
    ->format('H:i') }}
–
{{ $booking->ends_at
    ->setTimezone($booking->guest_timezone)
    ->format('H:i') }}

See you!