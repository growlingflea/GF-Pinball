<?php
// app/Http/Controllers/LeagueTeamController.php
namespace App\Http\Controllers;

use App\Models\LeagueTeam;
use Illuminate\Http\Request;

class LeagueTeamController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:league_teams,name',
        ]);

        $team = LeagueTeam::create($data);

        return response()->json($team);
    }
}
