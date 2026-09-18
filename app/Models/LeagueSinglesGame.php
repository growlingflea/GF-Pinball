<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/LeagueSinglesGame.php
class LeagueSinglesGame extends Model
{
    protected $fillable = [
        'league_match_id','round_number','game_number','machine_name',
        'home_player_id','home_score','away_player_id','away_score',
    ];

    protected $casts = [
        'match_date' => 'date',
    ];

    public function getHomePointsAttribute(): int
    {
        return $this->points('home');
    }

    public function getAwayPointsAttribute(): int
    {
        return $this->points('away');
    }

    protected function points(string $side): int
    {
        if ($this->home_score === null || $this->away_score === null) return 0;

        $mine   = $side === 'home' ? $this->home_score : $this->away_score;
        $theirs = $side === 'home' ? $this->away_score : $this->home_score;

        if ($mine > $theirs) {
            $points = 2; // win
            if ($mine >= $theirs * 2) $points++; // double-score bonus
            return $points;
        }

        if ($mine < $theirs) {
            // consolation point if my score is more than half the winner's
            return $mine > ($theirs / 2) ? 1 : 0;
        }

        return 0; // tie — sheet doesn't define this case; flagged below
    }
}
