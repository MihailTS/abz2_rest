<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Head extends Employee
{
    protected $table = 'employees';

    public function subordinates(){
        return $this->hasMany(Employee::class, 'head_id');
    }
}
