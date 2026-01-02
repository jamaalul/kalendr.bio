<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $state = 'dashboard';

        // 1. Accepted/Confirmed Bookings (for Calendar)
        // We might want to fetch a range, but for now let's fetch all future or recent/future bookings
        // so the calendar can display them. Let's say, everything from 1 month ago onwards?
        // Or just all 'accepted' ones if the volume isn't huge.
        // Let's filter by eventType.user_id = auth user.
        
        $bookings = Booking::whereHas('eventType', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->whereIn('status', ['accepted', 'completed']) // Show accepted (and maybe completed) on calendar
        ->get();

        // 2. Unaccepted Bookings (Proposed) - For the list
        $unacceptedBookings = Booking::whereHas('eventType', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->where('status', 'proposed')
        ->orderBy('starts_at', 'asc')
        ->get();

        // 3. Cancellation Proposals (Cancellation Requested) - For the list
        $cancellationProposals = Booking::whereHas('eventType', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->where('status', 'cancellation_requested')
        ->orderBy('starts_at', 'asc')
        ->get();

        return view('dashboard.index', compact('state', 'bookings', 'unacceptedBookings', 'cancellationProposals'));
    }
}
