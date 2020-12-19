<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreDeveloper extends Model
{
    protected $fillable =[
        'name', 'devId', 'gameCount', 'email', 'lastReleasedDate', 'lastUpdatedDate', 'lastVersionDate', 'url', 'website', 'cover', 'icon', 'address'
    ];
}
