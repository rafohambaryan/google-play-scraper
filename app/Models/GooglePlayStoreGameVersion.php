<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGameVersion extends Model
{
    protected $fillable = [
      'game_id', 'version'
    ];
}
