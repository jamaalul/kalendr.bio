<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EventTypeController extends Controller
{
    public function index()
    {
        $user  = Auth::user();

        $eventTypes = $user->eventTypes->sortByDesc('created_at');
        $bookings = $user->bookings()->select('bookings.*')->with('eventType')->where('status', 'proposed')->get()->sortByDesc('created_at');
        $state = 'agenda';

        return view('dashboard.event-types.index', ['agendas' => $eventTypes, 'state' => $state, 'bookings' => $bookings]);
    }

    public function create()
    {
        $state = 'agenda';
        return view('dashboard.event-types.create', compact('state'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'timezone' => 'required|timezone',
            'is_active' => 'nullable|boolean',
            'availability' => 'nullable|array',
            'availability.*.*.start_time' => 'nullable|date_format:H:i',
            'availability.*.*.end_time' => 'nullable|date_format:H:i',
        ]);

        // Custom validation for time ranges
        $this->validateAvailability($request->input('availability', []));

        DB::beginTransaction();
        try {
            $eventType = Auth::user()->eventTypes()->create([
                'name' => $validated['name'],
                'duration_minutes' => $validated['duration_minutes'],
                'timezone' => $validated['timezone'],
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            $this->syncAvailabilities($eventType, $request->input('availability', []));

            DB::commit();

            return redirect('/event-types')->with('success', 'Agenda berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function edit(EventType $eventType)
    {
        // Ensure user can only edit their own event types
        if ($eventType->user_id !== Auth::id()) {
            abort(403);
        }

        $state = 'agenda';
        
        // Group availabilities by day_of_week for easy rendering
        $availabilitiesByDay = $eventType->eventTypeAvailabilities
            ->groupBy('day_of_week')
            ->map(function ($slots) {
                return $slots->map(function ($slot) {
                    return (object) [
                        'start_time' => substr($slot->start_time, 0, 5), // Format: HH:MM
                        'end_time' => substr($slot->end_time, 0, 5),
                    ];
                });
            })
            ->toArray();

        return view('dashboard.event-types.edit', compact('eventType', 'availabilitiesByDay', 'state'));
    }

    public function update(Request $request, EventType $eventType)
    {
        // Ensure user can only update their own event types
        if ($eventType->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'timezone' => 'required|timezone',
            'is_active' => 'nullable|boolean',
            'availability' => 'nullable|array',
            'availability.*.*.start_time' => 'nullable|date_format:H:i',
            'availability.*.*.end_time' => 'nullable|date_format:H:i',
        ]);

        // Custom validation for time ranges
        $this->validateAvailability($request->input('availability', []));

        DB::beginTransaction();
        try {
            $eventType->update([
                'name' => $validated['name'],
                'duration_minutes' => $validated['duration_minutes'],
                'timezone' => $validated['timezone'],
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            $this->syncAvailabilities($eventType, $request->input('availability', []));

            DB::commit();

            return redirect('/event-types')->with('success', 'Agenda berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Sync event type availabilities
     * Deletes all existing and recreates from submitted data
     */
    private function syncAvailabilities(EventType $eventType, array $availability)
    {
        // Delete all existing availabilities for this event type
        $eventType->eventTypeAvailabilities()->delete();

        // Create new availabilities from submitted data
        foreach ($availability as $dayOfWeek => $slots) {
            foreach ($slots as $slot) {
                // Only create if both start and end time are provided
                if (!empty($slot['start_time']) && !empty($slot['end_time'])) {
                    $eventType->eventTypeAvailabilities()->create([
                        'day_of_week' => $dayOfWeek,
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                    ]);
                }
            }
        }
    }

    /**
     * Custom validation for availability time ranges
     */
    private function validateAvailability(array $availability)
    {
        foreach ($availability as $dayOfWeek => $slots) {
            $validSlots = [];
            
            foreach ($slots as $slot) {
                // Skip empty slots
                if (empty($slot['start_time']) || empty($slot['end_time'])) {
                    continue;
                }

                // Validate end_time is after start_time
                if ($slot['end_time'] <= $slot['start_time']) {
                    throw ValidationException::withMessages([
                        'availability' => ["Waktu selesai harus lebih besar dari waktu mulai pada hari ke-{$dayOfWeek}."],
                    ]);
                }

                $validSlots[] = $slot;
            }

            // Check for overlapping time ranges within the same day
            for ($i = 0; $i < count($validSlots); $i++) {
                for ($j = $i + 1; $j < count($validSlots); $j++) {
                    $slot1 = $validSlots[$i];
                    $slot2 = $validSlots[$j];

                    // Check if ranges overlap
                    if (
                        ($slot1['start_time'] < $slot2['end_time'] && $slot1['end_time'] > $slot2['start_time']) ||
                        ($slot2['start_time'] < $slot1['end_time'] && $slot2['end_time'] > $slot1['start_time'])
                    ) {
                        throw ValidationException::withMessages([
                            'availability' => ["Terdapat waktu yang tumpang tindih pada hari ke-{$dayOfWeek}."],
                        ]);
                    }
                }
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType)
    {
        // Ensure user can only delete their own event types
        if ($eventType->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if there are any bookings associated with this event type
        if ($eventType->bookings()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus agenda karena sudah ada janji temu yang terhubung.');
        }

        DB::beginTransaction();
        try {
            // Availabilities will be deleted via cascade if set up in DB, 
            // but we can explicitly delete them here to be safe and clear.
            $eventType->eventTypeAvailabilities()->delete();
            
            // Delete the event type
            $eventType->delete();

            DB::commit();

            return redirect()->route('event-types.index')->with('success', 'Agenda berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus agenda: ' . $e->getMessage());
        }
    }
}
