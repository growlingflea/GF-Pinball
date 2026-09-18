<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    protected $fillable = [
        'name', 'slug', 'manufacturer', 'year',
        'cheat_sheet_pdf', 'cheat_sheet_png', 'has_simulator', 'is_active',
    ];

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class)
            ->withPivot(['placed_at', 'removed_at'])
            ->withTimestamps();
    }

    public function rulesheet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Rulesheet::class);
    }

    public function venues()
    {
        return $this->belongsToMany(Venue::class)->withPivot('pinball_map_lmx_id')->withTimestamps();
    }
}
