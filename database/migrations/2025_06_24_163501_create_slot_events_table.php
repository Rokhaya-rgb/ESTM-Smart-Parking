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
        Schema::create('slot_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained('parking_slots');
            $table->string('status_before');
            $table->string('status_after');
            $table->timestamp('detected_at');
            $table->string('source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_events');
    }
};
