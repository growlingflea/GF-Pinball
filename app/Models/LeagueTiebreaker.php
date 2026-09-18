<?php

// app/Models/LeagueTiebreaker.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTiebreaker extends Model
{
    protected $fillable = [
        'league_match_id',
        'machine_name',
        'format',
        'home_players',
        'away_players',
        'winner',
    ];

    protected $casts = [
        'home_players' => 'array',
        'away_players' => 'array',
    ];

    public function match()
    {
        return $this->belongsTo(LeagueMatch::class, 'league_match_id');
    }
}
