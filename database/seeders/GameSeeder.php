<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            // Existing / built
            ['name' => 'Jaws (Pro)', 'slug' => 'jaws-pro', 'manufacturer' => 'Stern', 'year' => 2024, 'has_simulator' => true],

            // Moonshot
            ['name' => 'AC/DC (Pro)', 'slug' => 'ac-dc-pro', 'manufacturer' => 'Stern', 'year' => 2012],
            ['name' => 'Guardians of the Galaxy (Pro)', 'slug' => 'guardians-of-the-galaxy-pro', 'manufacturer' => 'Stern', 'year' => 2017],
            ['name' => 'NBA', 'slug' => 'nba', 'manufacturer' => 'Stern', 'year' => 2009],
            ['name' => 'Revenge from Mars', 'slug' => 'revenge-from-mars', 'manufacturer' => 'Bally', 'year' => 1999],
            ['name' => 'Star Wars (LE)', 'slug' => 'star-wars-le', 'manufacturer' => 'Stern', 'year' => 2017],

            // Gift
            ['name' => 'Avengers: Infinity Quest (Pro)', 'slug' => 'avengers-infinity-quest-pro', 'manufacturer' => 'Stern', 'year' => 2020],
            ['name' => 'Cactus Canyon (Remake LE)', 'slug' => 'cactus-canyon-remake-le', 'manufacturer' => 'Chicago Gaming', 'year' => 2021],
            ['name' => "Dungeons & Dragons: The Tyrant's Eye (Pro)", 'slug' => 'dungeons-and-dragons-tyrants-eye-pro', 'manufacturer' => 'Stern', 'year' => 2025],
            ['name' => 'Foo Fighters (Pro)', 'slug' => 'foo-fighters-pro', 'manufacturer' => 'Stern', 'year' => 2023],
            ['name' => 'Future Spa', 'slug' => 'future-spa', 'manufacturer' => 'Bally', 'year' => 1979],
            ['name' => 'Metallica (Pro)', 'slug' => 'metallica-pro', 'manufacturer' => 'Stern', 'year' => 2013],
            ['name' => 'Out of Sight', 'slug' => 'out-of-sight', 'manufacturer' => 'Gottlieb', 'year' => 1974],
            ['name' => 'Pinball Pool', 'slug' => 'pinball-pool', 'manufacturer' => 'Gottlieb', 'year' => 1979],
            ['name' => 'Pokémon (Pro)', 'slug' => 'pokemon-pro', 'manufacturer' => 'Stern', 'year' => 2026],
            ['name' => 'The Shadow', 'slug' => 'the-shadow', 'manufacturer' => 'Bally', 'year' => 1994],
            ['name' => 'Vulcan', 'slug' => 'vulcan', 'manufacturer' => 'Gottlieb', 'year' => 1977],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(
                ['slug' => $game['slug']],
                array_merge(['has_simulator' => false, 'is_active' => true], $game)
            );
        }
    }
}
