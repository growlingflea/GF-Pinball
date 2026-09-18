<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

// app/Http/Requests/StoreLeagueMatchRequest.php
class StoreLeagueMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // no auth yet — noted for when login is added
    }

    public function rules(): array
    {
        return [
            'match_date' => 'required|date',
            'home_team_id' => 'required|exists:league_teams,id',
            'away_team_id' => 'required|exists:league_teams,id|different:home_team_id',
            'home_initials' => 'nullable|string|max:10',
            'away_initials' => 'nullable|string|max:10',

            'doubles' => 'array',
            'doubles.*.round_number' => 'required_with:doubles.*|in:1,4',
            'doubles.*.game_number' => 'required_with:doubles.*|integer|min:1|max:3',
            'doubles.*.machine_name' => 'nullable|string|max:255',
            'doubles.*.team_a_p1_id' => 'nullable|exists:league_players,id',
            'doubles.*.team_a_p1_score' => 'nullable|integer|min:0',
            'doubles.*.team_a_p2_id' => 'nullable|exists:league_players,id',
            'doubles.*.team_a_p2_score' => 'nullable|integer|min:0',
            'doubles.*.team_b_p1_id' => 'nullable|exists:league_players,id',
            'doubles.*.team_b_p1_score' => 'nullable|integer|min:0',
            'doubles.*.team_b_p2_id' => 'nullable|exists:league_players,id',
            'doubles.*.team_b_p2_score' => 'nullable|integer|min:0',
            'doubles.*.team_a_is_home' => 'required_with:doubles.*|boolean',

            'singles' => 'array',
            'singles.*.round_number' => 'required_with:singles.*|in:2,3',
            'singles.*.game_number' => 'required_with:singles.*|integer|min:1|max:6',
            'singles.*.machine_name' => 'nullable|string|max:255',
            'singles.*.home_player_id' => 'nullable|exists:league_players,id',
            'singles.*.home_score' => 'nullable|integer|min:0',
            'singles.*.away_player_id' => 'nullable|exists:league_players,id',
            'singles.*.away_score' => 'nullable|integer|min:0',

            'tiebreaker.machine_name' => 'nullable|string|max:255',
            'tiebreaker.format' => 'nullable|in:split,shared',
            'tiebreaker.home_players' => 'nullable|array',
            'tiebreaker.away_players' => 'nullable|array',
            'tiebreaker.winner' => 'nullable|in:home,away',
        ];
    }

    public function matchAttributes(): array
    {
        return $this->only(['match_date', 'home_team_id', 'away_team_id', 'home_initials', 'away_initials']);
    }

    public function doublesGames(): array
    {
        return $this->input('doubles', []);
    }

    public function singlesGames(): array
    {
        return $this->input('singles', []);
    }

    public function tiebreakerAttributes(): ?array
    {
        $tb = $this->input('tiebreaker');
        return $tb && array_filter($tb) ? $tb : null;
    }
}
