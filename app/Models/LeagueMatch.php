<?php

// app/Models/LeagueMatch.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMatch extends Model
{
    protected $fillable = [
        'match_date',
        'home_team_id',
        'away_team_id',
        'home_initials',
        'away_initials',
        'status',
    ];

    protected $casts = [
        'match_date' => 'date',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(LeagueTeam::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(LeagueTeam::class, 'away_team_id');
    }

    public function doublesGames()
    {
        return $this->hasMany(LeagueDoublesGame::class);
    }

    public function singlesGames()
    {
        return $this->hasMany(LeagueSinglesGame::class);
    }

    public function tiebreaker()
    {
        return $this->hasOne(LeagueTiebreaker::class);
    }

    public function roundTotals(int $roundNumber): array
    {
        $games = in_array($roundNumber, [1, 4])
            ? $this->doublesGames->where('round_number', $roundNumber)
            : $this->singlesGames->where('round_number', $roundNumber);

        return [
            'home' => $games->sum('home_points'),
            'away' => $games->sum('away_points'),
        ];
    }

    public function getMatchTotalAttribute(): array
    {
        $home = collect(range(1, 4))->sum(fn ($r) => $this->roundTotals($r)['home']);
        $away = collect(range(1, 4))->sum(fn ($r) => $this->roundTotals($r)['away']);

        return ['home' => $home, 'away' => $away];
    }
}
