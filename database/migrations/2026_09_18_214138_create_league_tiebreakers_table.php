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
        Schema::create('league_tiebreakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_match_id')->constrained()->cascadeOnDelete();
            $table->string('machine_name')->nullable();
            $table->enum('format', ['split', 'shared'])->nullable();
            $table->json('away_players')->nullable(); // ["Name"] or ["Name1","Name2"]
            $table->json('home_players')->nullable();
            $table->enum('winner', ['home', 'away'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_tiebreakers');
    }
};
