<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunCronJob extends Model
{
    protected $fillable = [
        'start', 'end', 'request', 'loop', 'name', 'new'
    ];
}
