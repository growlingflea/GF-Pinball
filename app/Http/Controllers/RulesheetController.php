<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Rulesheet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RulesheetController extends Controller
{
    /**
     * Search/browse page: every known game gets a card (Simulator / Cheat
     * Sheet / Rulesheet / Coming Soon badge), plus stub cards for imported
     * rulesheets that don't have a matching game record yet.
     */
    public function index()
    {
        $games = Game::where('is_active', true)->with('rulesheet')->get()->map(function (Game $game) {
            return [
                'type' => 'game',
                'id' => $game->id,
                'title' => $game->name,
                'manufacturer' => $game->manufacturer,
                'thumbnail' => $this->thumbnailFor($game->slug),
                'badge' => $this->badgeFor($game),
                'url' => route('games.show', $game->slug),
            ];
        });

        $stubRulesheets = Rulesheet::whereNull('game_id')->get()->map(function (Rulesheet $rulesheet) {
            return [
                'type' => 'rulesheet',
                'id' => $rulesheet->id,
                'title' => $rulesheet->title,
                'manufacturer' => $rulesheet->manufacturer,
                'thumbnail' => null,
                'badge' => 'Rulesheet',
                'url' => route('rulesheets.show', $rulesheet->id),
            ];
        });

        $cards = $games->concat($stubRulesheets)->sortBy('title')->values();

        return view('rulesheets.index', ['cards' => $cards]);
    }

    /**
     * Fallback display for a rulesheet-only entry (no game record / no
     * cheat sheet or simulator asset yet) — pretty-prints content_markdown.
     */
    public function show(Rulesheet $rulesheet)
    {
        return view('rulesheets.show', [
            'rulesheet' => $rulesheet,
            'html' => Str::markdown($rulesheet->content_markdown),
        ]);
    }

    private function badgeFor(Game $game): string
    {
        if ($game->has_simulator) {
            return 'Simulator';
        }

        if ($game->cheat_sheet_pdf || $game->cheat_sheet_png) {
            return 'Cheat Sheet';
        }

        if ($game->rulesheet) {
            return 'Rulesheet';
        }

        return 'Coming Soon';
    }

    private function thumbnailFor(string $slug): ?string
    {
        $files = Storage::disk('public')->files("playfields/{$slug}");

        return $files ? Storage::url($files[0]) : null;
    }
}
