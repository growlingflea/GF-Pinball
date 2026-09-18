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
        Schema::create('league_matches', function (Blueprint $table) {
            $table->id();
            $table->date('match_date');
            $table->foreignId('home_team_id')->constrained('league_teams');
            $table->foreignId('away_team_id')->constrained('league_teams');
            $table->string('home_initials')->nullable();
            $table->string('away_initials')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_matches');
    }
};
