<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'slug', 'manufacturer', 'year',
        'cheat_sheet_pdf', 'cheat_sheet_png', 'is_active',
    ];
}
