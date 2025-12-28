<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EventType;
use App\Models\Booking;
use App\Models\EventTypeAvailability;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingSlotExceptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_slot_exception()
    {
        // 1. Setup Data
        $user = User::factory()->create(['username' => 'testuser']);
        $eventType = EventType::create([
            'user_id' => $user->id,
            'name' => 'Test Event',
            'slug' => 'test-event',
            'duration_minutes' => 30,
            'is_active' => true,
            'timezone' => 'UTC',
        ]);

        // Available on Mondays 09:00 - 10:00 (2 slots: 09:00-09:30, 09:30-10:00)
        EventTypeAvailability::create([
            'event_type_id' => $eventType->id,
            'day_of_week' => 1, // Monday
            'start_time' => '09:00',
            'end_time' => '10:00',
        ]);

        // Determine next Monday
        $nextMonday = Carbon::parse('next Monday');
        $slotStart = $nextMonday->copy()->setTime(9, 0, 0); // 09:00 UTC

        // 2. Verify Slot is Initially Available
        $response = $this->get('/testuser/test-event');
        $response->assertStatus(200);
        // We can't easily parse the HTML for the exact slot data in this basic test without more detailed crawling,
        // but we can check the database or use the service directly.
        // Let's use the route to Book logic to verify availability implicitly by successful booking.

        // 3. Book the First Slot
        $response = $this->post("/testuser/test-event/book", [
            'starts_at_utc' => $slotStart->toIso8601String(),
            'guest_name' => 'Guest 1',
            'guest_email' => 'guest1@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(); // Should redirect to confirmation

        $this->assertDatabaseHas('bookings', [
            'guest_email' => 'guest1@example.com',
            'starts_at' => $slotStart->format('Y-m-d H:i:s'),
        ]);

        // 4. Try to Book the SAME Slot Again (Should Fail)
        // Note: The controller logic returns an error or just doesn't create booking returning to back()
        // The implementation says: return back()->withErrors(...)
        
        $response = $this->post("/testuser/test-event/book", [
            'starts_at_utc' => $slotStart->toIso8601String(),
            'guest_name' => 'Guest 2',
            'guest_email' => 'guest2@example.com',
        ]);

        // Should have error about slot booked
        $response->assertSessionHasErrors(['slot']);
        $this->assertDatabaseMissing('bookings', [
            'guest_email' => 'guest2@example.com',
        ]);
    }
}
