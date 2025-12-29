<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class CompleteBookings extends Command
{
    protected $signature = 'bookings:complete';

    protected $description = 'Mark past accepted bookings as completed';

    public function handle(): int
    {
        $count = Booking::where('status', 'accepted')
            ->where('ends_at', '<', now())
            ->update([
                'status' => 'completed',
            ]);

        $this->info("Completed {$count} bookings.");

        return Command::SUCCESS;
    }
}
