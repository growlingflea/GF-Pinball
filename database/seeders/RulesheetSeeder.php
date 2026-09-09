<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Rulesheet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RulesheetSeeder extends Seeder
{
    /**
     * Loads the committed database/seeders/data/rulesheets.json (produced
     * by `php artisan rulesheets:import`) into the rulesheets table.
     * Matches each rulesheet to a game by opdb_id where possible; anything
     * unmatched still gets stored with game_id null so it can be linked
     * manually later.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/rulesheets.json');

        if (! File::exists($path)) {
            $this->command?->warn("No rulesheets.json found at {$path} — run `php artisan rulesheets:import` first.");

            return;
        }

        $rows = json_decode(File::get($path), true) ?? [];

        $matched = 0;

        foreach ($rows as $row) {
            $gameId = null;

            if (! empty($row['opdb_id'])) {
                $gameId = Game::where('opdb_id', $row['opdb_id'])->value('id');
            }

            if ($gameId) {
                $matched++;
            }

            Rulesheet::updateOrCreate(
                ['source_path' => $row['source_path']],
                [
                    'game_id' => $gameId,
                    'opdb_id' => $row['opdb_id'] ?? null,
                    'manufacturer' => $row['manufacturer'] ?? null,
                    'title' => $row['title'],
                    'content_markdown' => $row['content_markdown'],
                    'imported_at' => now(),
                ]
            );
        }

        $this->command?->info(count($rows)." rulesheets seeded ({$matched} matched to an existing game).");
    }
}
