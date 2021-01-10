<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGameAddCategory extends CModel
{
    protected $fillable = [
      'game_id', 'category_id', 'name', 'code'
    ];
}
