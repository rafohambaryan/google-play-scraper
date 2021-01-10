<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class UniqeEmailData extends CModel
{
    protected $fillable = [
      'email', 'send'
    ];
}
