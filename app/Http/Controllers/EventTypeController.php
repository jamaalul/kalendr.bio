<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventTypeController extends Controller
{
    public function index()
    {
        $eventTypes = Auth::user()->eventTypes;

        return view('event-types.index', compact('eventTypes'));
    }

    public function create()
    {
        return view('event-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480',
        ]);

        Auth::user()->eventTypes()->create($data);

        return redirect('/event-types');
    }
}
