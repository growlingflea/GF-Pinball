<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return view('welcome');
});

//Routes generate by ClaudeAI
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');

// Stubs for the rest — build these views out next
Route::get('/games/{game:slug}/cheat-sheet', [GameController::class, 'cheatSheet'])->name('games.cheat-sheet');
Route::get('/games/{game:slug}/simulator', [GameController::class, 'simulator'])->name('games.simulator');
Route::get('/games/{game:slug}/comments', [GameController::class, 'comments'])->name('games.comments');
Route::get('/games/{game:slug}/playfield', [GameController::class, 'playfield'])->name('games.playfield');
Route::get('/locations/{location:slug}', [LocationController::class, 'show'])->name('locations.show');
