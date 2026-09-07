<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $moonshot = Location::updateOrCreate(['slug' => 'moonshot'], ['name' => 'Moonshot']);
        $gift = Location::updateOrCreate(['slug' => 'gift'], ['name' => 'Gift']);

        $this->attachGames($moonshot, [
            'ac-dc-pro',
            'guardians-of-the-galaxy-pro',
            'nba',
            'revenge-from-mars',
            'star-wars-le',
        ]);

        $this->attachGames($gift, [
            'avengers-infinity-quest-pro',
            'cactus-canyon-remake-le',
            'dungeons-and-dragons-tyrants-eye-pro',
            'foo-fighters-pro',
            'future-spa',
            'jaws-pro',
            'metallica-pro',
            'out-of-sight',
            'pinball-pool',
            'pokemon-pro',
            'the-shadow',
            'vulcan',
        ]);
    }

    private function attachGames(Location $location, array $slugs): void
    {
        foreach ($slugs as $slug) {
            $game = Game::where('slug', $slug)->first();

            if (! $game) {
                continue;
            }

            $location->games()->syncWithoutDetaching([
                $game->id => ['placed_at' => now()],
            ]);
        }
    }
}
