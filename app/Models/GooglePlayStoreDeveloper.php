<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class GooglePlayStoreDeveloper extends CModel
{
    protected $fillable =[
        'name', 'devId', 'gameCount', 'email', 'lastReleasedDate', 'lastUpdatedDate', 'lastVersionDate', 'url', 'website', 'cover', 'icon', 'address'
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
    public function getGames(){
        return $this->hasMany(GooglePlayStoreGame::class,'developer_id','id');
    }
}
