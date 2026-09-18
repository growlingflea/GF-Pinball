<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/LeagueDoublesGame.php
class LeagueDoublesGame extends Model
{
    protected $fillable = [
        'league_match_id','round_number','game_number','machine_name',
        'team_a_p1_id','team_a_p1_score','team_a_p2_id','team_a_p2_score',
        'team_b_p1_id','team_b_p1_score','team_b_p2_id','team_b_p2_score',
        'team_a_is_home',
    ];

    protected $casts = [
        'match_date' => 'date',
    ];

    public function getHomePointsAttribute(): int
    {
        return $this->team_a_is_home ? $this->teamPoints('a') : $this->teamPoints('b');
    }

    public function getAwayPointsAttribute(): int
    {
        return $this->team_a_is_home ? $this->teamPoints('b') : $this->teamPoints('a');
    }

    protected function teamPoints(string $side): int
    {
        $mine  = $side === 'a' ? [$this->team_a_p1_score, $this->team_a_p2_score] : [$this->team_b_p1_score, $this->team_b_p2_score];
        $theirs = $side === 'a' ? [$this->team_b_p1_score, $this->team_b_p2_score] : [$this->team_a_p1_score, $this->team_a_p2_score];

        if (in_array(null, $mine, true) || in_array(null, $theirs, true)) return 0;

        $points = (array_sum($mine) > array_sum($theirs)) ? 2 : 0; // team win bonus

        foreach ($mine as $myScore) {
            foreach ($theirs as $theirScore) {
                if ($myScore > $theirScore) $points++; // 1 pt per opponent individually beaten
            }
        }

        return $points;
    }
}
