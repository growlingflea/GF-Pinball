<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RulesheetController;

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


Route::get('/rulesheets', [RulesheetController::class, 'index'])->name('rulesheets.index');
Route::get('/rulesheets/{rulesheet}', [RulesheetController::class, 'show'])->name('rulesheets.show');

// Coming Soon placeholders — replace each with a real controller as
// that feature gets built; the route name is what the nav links to,
// so nothing in the nav partial needs to change when you do.
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');Route::view('/calendar', 'coming-soon', ['feature' => 'Calendar'])->name('calendar.index');
Route::view('/simulators', 'coming-soon', ['feature' => 'Show Simulator'])->name('simulators.index');
Route::view('/account', 'coming-soon', ['feature' => 'Account'])->name('account.index');
Route::view('/about', 'coming-soon', ['feature' => 'About'])->name('about.index');
