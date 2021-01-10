<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGameVersion extends CModel
{
    protected $fillable = [
      'game_id', 'version'
    ];
}
