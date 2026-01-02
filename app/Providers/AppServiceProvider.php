<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('dashboard.navbar', function ($view) {
            if (auth()->check()) {
                $pendingBookingCount = \App\Models\Booking::whereHas('eventType', function ($q) {
                    $q->where('user_id', auth()->id());
                })->where('status', 'proposed')->count();

                $pendingCancellationCount = \App\Models\Booking::whereHas('eventType', function ($q) {
                    $q->where('user_id', auth()->id());
                })->where('status', 'cancellation_requested')->count();

                $view->with('pendingBookingCount', $pendingBookingCount)
                     ->with('pendingCancellationCount', $pendingCancellationCount);
            }
        });
    }
}
