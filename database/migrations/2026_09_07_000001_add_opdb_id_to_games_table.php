<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * opdb_id is the Open Pinball Database identifier. It's the common key
     * shared by Pinball Map (used for backglass images) and the Pinball
     * Rulesheets project, so it's a more reliable cross-reference than
     * pinball_map_machine_id alone.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('opdb_id')->nullable()->index()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('opdb_id');
        });
    }
};
