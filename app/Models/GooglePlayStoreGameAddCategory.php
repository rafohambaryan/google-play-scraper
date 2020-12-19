<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreGameAddCategory extends Model
{
    protected $fillable = [
      'game_id', 'category_id', 'name', 'code'
    ];
}
