<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Imported rulesheet content, sourced from the community-maintained
     * Pinball Rulesheets project (github.com/heyrocker/pinballrules),
     * successor to the closed Tilt Forums rulesheet wiki. Used as a
     * fallback on the cheat sheet / simulator pages when we don't yet
     * have our own asset for a machine.
     */
    public function up(): void
    {
        Schema::create('rulesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->nullable()->constrained('games')->nullOnDelete();
            $table->string('opdb_id')->nullable()->index();
            $table->string('manufacturer')->nullable();
            $table->string('title');
            $table->string('source_path')->unique();
            $table->longText('content_markdown');
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rulesheets');
    }
};
