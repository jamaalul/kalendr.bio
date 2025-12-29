<?php

use App\Http\Controllers\{
    ProfileController,
    EventTypeController,
    AvailabilityController,
    BookingController
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : view('landing');
});

// Public Booking Process
Route::controller(BookingController::class)->group(function () {
    Route::get('/{username}/{eventTypeSlug}', 'show')->name('bookings.show');
    Route::post('/{username}/{eventTypeSlug}/book', 'book')->name('bookings.submit');
    Route::get('/{username}/{eventTypeSlug}/book/{booking}', 'confirmation')->name('bookings.confirmation');
});

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Home
    Route::get('/dashboard', function () {
        return view('dashboard.index', ['state' => 'dashboard']);
    })->name('dashboard');

    // Profile Management
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    // Event Types Management
    Route::prefix('event-types')->name('event-types.')->group(function () {
        Route::controller(EventTypeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{eventType}/edit', 'edit')->name('edit');
            Route::put('/{eventType}', 'update')->name('update');
        });

        // Nested Availability (related to a specific Event Type)
        Route::controller(AvailabilityController::class)->group(function () {
            Route::get('/{eventType}/availability', 'index')->name('availability.index');
            Route::post('/{eventType}/availability', 'store')->name('availability.store');
        });
    });

    // Internal Booking Actions (Accept/Reject)
    Route::controller(BookingController::class)->prefix('bookings')->name('booking.')->group(function () {
        Route::post('/accept', 'accept')->name('accept');
        Route::post('/reject', 'reject')->name('reject');
    });
});

require __DIR__ . '/auth.php';
