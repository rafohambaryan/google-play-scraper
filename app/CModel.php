<?php


namespace App;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class CModel extends Model
{

    public function __construct(array $attributes = [])
    {
//        $user = User::find(1);
//
//        if (!$user){
//            throw new \Exception('user find 1 not fount');
//        }
        parent::__construct($attributes);
    }

}
