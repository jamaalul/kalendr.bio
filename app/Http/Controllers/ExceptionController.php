<?php

namespace App\Http\Controllers;

use App\Models\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExceptionController extends Controller
{
    /**
     * Display a listing of the user's exceptions.
     */
    public function index()
    {
        $state = 'libur';
        $exceptions = Exception::where('user_id', Auth::id())
            ->orderBy('start_datetime', 'asc')
            ->get();

        return view('dashboard.exceptions.index', compact('state', 'exceptions'));
    }

    /**
     * Show the form for creating a new exception.
     */
    public function create()
    {
        $state = 'libur';
        return view('dashboard.exceptions.create', compact('state'));
    }

    /**
     * Store a newly created exception in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string|max:255',
        ]);

        $startDatetime = Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        $endDatetime = Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);

        // Validate end is after start
        if ($endDatetime->lte($startDatetime)) {
            return back()->withErrors(['end_time' => 'Waktu selesai harus setelah waktu mulai'])->withInput();
        }

        Exception::create([
            'user_id' => Auth::id(),
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('exceptions.index')
            ->with('success', 'Libur berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified exception.
     */
    public function edit(Exception $exception)
    {
        // Ensure user owns this exception
        if ($exception->user_id !== Auth::id()) {
            abort(403);
        }

        $state = 'libur';
        return view('dashboard.exceptions.edit', compact('state', 'exception'));
    }

    /**
     * Update the specified exception in storage.
     */
    public function update(Request $request, Exception $exception)
    {
        // Ensure user owns this exception
        if ($exception->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string|max:255',
        ]);

        $startDatetime = Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        $endDatetime = Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);

        // Validate end is after start
        if ($endDatetime->lte($startDatetime)) {
            return back()->withErrors(['end_time' => 'Waktu selesai harus setelah waktu mulai'])->withInput();
        }

        $exception->update([
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('exceptions.index')
            ->with('success', 'Libur berhasil diperbarui');
    }

    /**
     * Remove the specified exception from storage.
     */
    public function destroy(Exception $exception)
    {
        // Ensure user owns this exception
        if ($exception->user_id !== Auth::id()) {
            abort(403);
        }

        $exception->delete();

        return redirect()->route('exceptions.index')
            ->with('success', 'Libur berhasil dihapus');
    }
}
