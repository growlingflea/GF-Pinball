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
        Schema::create('league_players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('league_team_id')->nullable()->constrained('league_teams')->nullOnDelete();
            $table->boolean('is_sub')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_players');
    }
};
