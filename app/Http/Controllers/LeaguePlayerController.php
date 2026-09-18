<?php

namespace App\Http\Controllers;

use App\Models\LeaguePlayer;
use Illuminate\Http\Request;

class LeaguePlayerController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'league_team_id' => 'required|exists:league_teams,id',
            'is_sub' => 'boolean',
        ]);

        $player = LeaguePlayer::create($data + ['is_sub' => $data['is_sub'] ?? true]);

        return response()->json($player);
    }
}
