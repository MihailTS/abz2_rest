<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Head extends Employee
{
    protected $table = 'employees';

    public function subordinates(){
        return $this->belongsToMany(Employee::class, 'head_id');
    }
}
