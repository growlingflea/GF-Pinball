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
        Schema::create('game_venue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            // Pinball Map's own xref id for this specific machine-at-location,
            // useful for diffing during sync instead of matching by name/opdb_id alone
            $table->unsignedInteger('pinball_map_lmx_id')->nullable();
            $table->timestamps();

            $table->unique(['game_id', 'venue_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_venue');
    }
};
