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
        Schema::table('event_types', function (Blueprint $table) {
            $table->unsignedInteger('minimum_notice_minutes')->default(0)->after('duration_minutes');
            $table->unsignedInteger('before_slot_padding_minutes')->default(0)->after('minimum_notice_minutes');
            $table->unsignedInteger('after_slot_padding_minutes')->default(0)->after('before_slot_padding_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_types', function (Blueprint $table) {
            $table->dropColumn([
                'minimum_notice_minutes',
                'before_slot_padding_minutes',
                'after_slot_padding_minutes',
            ]);
        });
    }
};
