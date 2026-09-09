<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name')->get();

        return view('locations.index', compact('locations'));
    }

    public function show(Location $location)
    {
        $games = $location->currentGames()->orderBy('name')->get();

        return view('locations.show', compact('location', 'games'));
    }
}
