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
        Schema::create('event_type_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_type_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 0 = Sunday, 1 = Monday ... 6 = Saturday
            $table->time('start_time'); // e.g. 09:00
            $table->time('end_time');   // e.g. 17:00
            $table->timestamps();
            $table->unique([
                'event_type_id',
                'day_of_week',
                'start_time',
                'end_time'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_type_availabilities');
    }
};
