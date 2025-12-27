<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\AvailabilityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : view('landing');
});

Route::get('/dashboard', function () {
    $state = 'dashboard';
    return view('dashboard.index', compact('state'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
 |--------------------------------------------------------------------------
 | EventType and Availability
 |--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/event-types', [EventTypeController::class, 'index']);
    Route::get('/event-types/create', [EventTypeController::class, 'create']);
    Route::post('/event-types', [EventTypeController::class, 'store']);
    Route::get('/event-types/{eventType}/edit', [EventTypeController::class, 'edit']);
    Route::put('/event-types/{eventType}', [EventTypeController::class, 'update']);


    Route::get('/event-types/{eventType}/availability', [AvailabilityController::class, 'index']);
    Route::post('/event-types/{eventType}/availability', [AvailabilityController::class, 'store']);
});

require __DIR__.'/auth.php';
