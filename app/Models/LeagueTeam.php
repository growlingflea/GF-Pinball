<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTeam extends Model
{
    protected $fillable = ['name'];
    public function players() { return $this->hasMany(LeaguePlayer::class); }
}
