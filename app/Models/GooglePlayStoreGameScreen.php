<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGameScreen extends Model
{
    protected $fillable = [
        'game_id', 'hashUrl', 'size', 'url'
    ];
}
