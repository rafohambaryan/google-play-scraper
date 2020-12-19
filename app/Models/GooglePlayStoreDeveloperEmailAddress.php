<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreDeveloperEmailAddress extends Model
{
    protected $fillable = [
        'email', 'dev_id'
    ];
}
