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
        // database/migrations/xxxx_create_league_doubles_games_table.php
        Schema::create('league_doubles_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_match_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('round_number');
            $table->unsignedTinyInteger('game_number');
            $table->string('machine_name')->nullable();
            $table->foreignId('team_a_p1_id')->nullable()->constrained('league_players')->nullOnDelete();
            $table->unsignedInteger('team_a_p1_score')->nullable();
            $table->foreignId('team_a_p2_id')->nullable()->constrained('league_players')->nullOnDelete();
            $table->unsignedInteger('team_a_p2_score')->nullable();
            $table->foreignId('team_b_p1_id')->nullable()->constrained('league_players')->nullOnDelete();
            $table->unsignedInteger('team_b_p1_score')->nullable();
            $table->foreignId('team_b_p2_id')->nullable()->constrained('league_players')->nullOnDelete();
            $table->unsignedInteger('team_b_p2_score')->nullable();
            $table->boolean('team_a_is_home');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_doubles_games');
    }
};
