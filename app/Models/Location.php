<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    protected $fillable = ['name', 'slug', 'pinball_map_location_id'];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)
            ->withPivot(['placed_at', 'removed_at'])
            ->withTimestamps();
    }

    /**
     * Games currently on the floor at this location (not yet removed).
     */
    public function currentGames(): BelongsToMany
    {
        return $this->games()->wherePivotNull('removed_at');
    }
}
