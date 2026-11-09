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
        Schema::table('parking_slots', function (Blueprint $table) {
            $table->boolean('is_reserved')->default(false);
            $table->string('reserved_for')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parking_slots', function (Blueprint $table) {
            $table->dropColumn('is_reserved');
            $table->dropColumn('reserved_for');
        });
    }
};
