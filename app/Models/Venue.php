<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = ['name', 'pinball_map_location_id'];

    public function games()
    {
        return $this->belongsToMany(Game::class)->withPivot('pinball_map_lmx_id')->withTimestamps();
    }
}
