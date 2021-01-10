<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreCategory extends CModel
{
    protected $fillable = [
        'category', 'code'
    ];
}
