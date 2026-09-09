<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rulesheet extends Model
{
    protected $fillable = [
        'game_id',
        'opdb_id',
        'manufacturer',
        'title',
        'source_path',
        'content_markdown',
        'imported_at',
    ];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
