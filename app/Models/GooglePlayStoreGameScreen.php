<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGameScreen extends CModel
{
    protected $fillable = [
        'game_id', 'hashUrl', 'size', 'url'
    ];
}
