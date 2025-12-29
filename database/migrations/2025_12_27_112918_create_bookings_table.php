<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_type_id')->constrained()->cascadeOnDelete();
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_timezone')->nullable(); // store guest tz for display/notifications
            $table->timestamp('starts_at'); // stored in UTC
            $table->timestamp('ends_at');   // stored in UTC
            $table->string('status')->default('proposed'); // proposed|accepted|cancelled|completed
            $table->timestamps();

            // Useful indexes for queries and overlap checks
            $table->index(['event_type_id', 'starts_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
