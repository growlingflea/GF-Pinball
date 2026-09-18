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
        Schema::create('league_singles_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_match_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('round_number'); // 2 or 3
            $table->unsignedTinyInteger('game_number');  // 1-6
            $table->string('machine_name')->nullable();
            $table->foreignId('home_player_id')->nullable()->constrained('league_players')->nullOnDelete();
            $table->unsignedInteger('home_score')->nullable();
            $table->foreignId('away_player_id')->nullable()->constrained('league_players')->nullOnDelete();
            $table->unsignedInteger('away_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_singles_games');
    }
};
