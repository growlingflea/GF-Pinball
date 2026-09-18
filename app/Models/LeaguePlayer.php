<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaguePlayer extends Model
{
    protected $fillable = ['name', 'league_team_id', 'is_sub'];
    protected $casts = [
        'match_date' => 'date',
    ];
    public function team() { return $this->belongsTo(LeagueTeam::class, 'league_team_id'); }
}
