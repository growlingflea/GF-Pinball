<?php

namespace App\Http\Controllers;

use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->get();
        return view('games.index', compact('games'));
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function cheatSheet(Game $game)
    {
        return view('games.cheat-sheet', compact('game'));
    }

    public function simulator(Game $game)
    {
        return view('games.simulator', compact('game'));
    }

    public function comments(Game $game)
    {
        return view('games.comments', compact('game'));
    }


    public function playfield(Game $game)
    {
        return view('games.playfield', compact('game'));
    }

}
?>
