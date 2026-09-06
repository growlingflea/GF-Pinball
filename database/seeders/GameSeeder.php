<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Game::create([
            'name' => 'Jaws (Pro)',
            'slug' => 'jaws-pro',
            'manufacturer' => 'Stern',
            'year' => 2019,
            'is_active' => true,
        ]);
    }
}
