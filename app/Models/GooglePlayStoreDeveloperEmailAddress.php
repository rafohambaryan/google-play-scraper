<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreDeveloperEmailAddress extends CModel
{
    protected $fillable = [
        'email', 'dev_id'
    ];

    public function save(array $options = [])
    {
        try {
            UniqeEmailData::create([
                'email' => $this->email
            ]);
        } catch (\Exception $exception) {
        }
        return parent::save($options);
    }
}
