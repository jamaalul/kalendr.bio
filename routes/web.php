<?php



use App\Http\Controllers\ProfileController;

use App\Http\Controllers\EventTypeController;

use App\Http\Controllers\AvailabilityController;

use App\Http\Controllers\BookingController;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;





Route::get('/', function () {

    return Auth::check() ? redirect('/dashboard') : view('landing');
});



Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');





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



    Route::get('/event-types', [EventTypeController::class, 'index'])->name('event-types.index');

    Route::get('/event-types/create', [EventTypeController::class, 'create'])->name('event-types.create');

    Route::post('/event-types', [EventTypeController::class, 'store']);

    Route::get('/event-types/{eventType}/edit', [EventTypeController::class, 'edit']);

    Route::put('/event-types/{eventType}', [EventTypeController::class, 'update']);

    Route::delete('/event-types/{eventType}', [EventTypeController::class, 'destroy'])->name('event-types.destroy');



    Route::post('/booking/accept', [BookingController::class, 'accept'])->name('booking.accept');

    Route::post('/booking/reject', [BookingController::class, 'reject'])->name('booking.reject');

    Route::get('/cancellation', [BookingController::class, 'cancellations'])->name('cancellations.index');



    Route::get('/event-types/{eventType}/availability', [AvailabilityController::class, 'index']);

    Route::post('/event-types/{eventType}/availability', [AvailabilityController::class, 'store']);
});



/*

 |--------------------------------------------------------------------------

 | Public Booking

 |--------------------------------------------------------------------------

*/



Route::get('/{username}/{eventTypeSlug}', [BookingController::class, 'show']);

Route::post('/{username}/{eventTypeSlug}/book', [BookingController::class, 'book']);

Route::get('/{username}/{eventTypeSlug}/book/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

Route::get('/booking/{booking}/cancel/{token}', [BookingController::class, 'showCancelForm'])->name('guest.booking.cancel.form');

Route::post('/booking/{booking}/cancel/{token}', [BookingController::class, 'requestCancellation'])->name('guest.booking.cancel.request');



require __DIR__ . '/auth.php';
