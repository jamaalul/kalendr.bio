<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AvailabilityController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(EventType $eventType)
    {
        $this->authorize('update', $eventType);

        return view('availability.index', [
            'eventType' => $eventType,
            'availabilities' => $eventType->availabilities,
        ]);
    }

    public function store(Request $request, EventType $eventType)
    {
        $this->authorize('update', $eventType);

        $data = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $eventType->availabilities()->create($data);

        return back();
    }
}
