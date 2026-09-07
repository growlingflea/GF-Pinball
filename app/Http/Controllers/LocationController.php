<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LocationController extends Controller
{
    public function show(Location $location)
    {
        $games = $location->currentGames()->orderBy('name')->get();

        return view('locations.show', compact('location', 'games'));
    }
}
