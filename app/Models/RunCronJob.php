<?php

namespace App\Models;

use App\CModel;
use Illuminate\Database\Eloquent\Model;

class RunCronJob extends CModel
{
    protected $fillable = [
        'start', 'end', 'request', 'loop', 'name', 'new', 'duration'
    ];

    public function save(array $options = [])
    {
        $date1 = new \DateTime($this->start);
        $date2 = new \DateTime($this->end);
        $diff = $date2->diff($date1);
        $this->duration = $diff->format('%H:%I:%S');
        return parent::save($options); // TODO: Change the autogenerated stub
    }
}
