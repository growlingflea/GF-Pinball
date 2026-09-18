<?php

namespace App\Http\Controllers;

use App\Models\LeagueMatch;
use App\Models\LeagueTeam;
use App\Models\LeaguePlayer;
use App\Http\Requests\StoreLeagueMatchRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// app/Http/Controllers/LeagueMatchController.php
class LeagueMatchController extends Controller
{
    public function index()
    {
        $matches = LeagueMatch::with('homeTeam', 'awayTeam')->latest('match_date')->paginate(20);
        return view('league.matches.index', compact('matches'));
    }

    public function create()
    {
        $teams = LeagueTeam::orderBy('name')->get();
        $players = LeaguePlayer::orderBy('name')->get(); // filtered client-side by team
        return view('league.matches.form', [
            'match' => new LeagueMatch(),
            'teams' => $teams,
            'players' => $players,
            'submitRoute' => route('league.matches.store'),
            'method' => 'POST',
        ]);
    }

    public function store(StoreLeagueMatchRequest $request)
    {
        $leagueMatch = DB::transaction(function () use ($request) {
            $match = LeagueMatch::create($request->matchAttributes());

            foreach ($request->doublesGames() as $game) {
                $match->doublesGames()->create($game);
            }
            foreach ($request->singlesGames() as $game) {
                $match->singlesGames()->create($game);
            }
            if ($tb = $request->tiebreakerAttributes()) {
                $match->tiebreaker()->create($tb);
            }

            return $match;
        });

        return redirect()->route('league.matches.show', $leagueMatch)
            ->with('status', 'Match saved.');
    }

    public function edit(LeagueMatch $leagueMatch)
    {
        $leagueMatch->load('doublesGames', 'singlesGames', 'tiebreaker');
        return view('league.matches.form', [
            'match' => $leagueMatch,
            'teams' => LeagueTeam::orderBy('name')->get(),
            'players' => LeaguePlayer::orderBy('name')->get(),
            'submitRoute' => route('league.matches.update', $leagueMatch),
            'method' => 'PUT',
        ]);
    }

    public function update(StoreLeagueMatchRequest $request, LeagueMatch $leagueMatch)
    {
        DB::transaction(function () use ($request, $leagueMatch) {
            $leagueMatch->update($request->matchAttributes());

            foreach ($request->doublesGames() as $game) {
                $leagueMatch->doublesGames()
                    ->updateOrCreate(['round_number' => $game['round_number'], 'game_number' => $game['game_number']], $game);
            }
            foreach ($request->singlesGames() as $game) {
                $leagueMatch->singlesGames()
                    ->updateOrCreate(['round_number' => $game['round_number'], 'game_number' => $game['game_number']], $game);
            }
            if ($tb = $request->tiebreakerAttributes()) {
                $leagueMatch->tiebreaker()->updateOrCreate([], $tb);
            }
        });

        return redirect()->route('league.matches.show', $leagueMatch)->with('status', 'Match updated.');
    }

    public function show(LeagueMatch $leagueMatch)
    {
        $leagueMatch->load('homeTeam', 'awayTeam', 'doublesGames.teamAP1', 'doublesGames.teamAP2', 'doublesGames.teamBP1', 'doublesGames.teamBP2', 'singlesGames.homePlayer', 'singlesGames.awayPlayer', 'tiebreaker');
        return view('league.matches.show', compact('leagueMatch'));
    }
}
