<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'salary',
        'employmentDate',
        'position_id',
        'avatar_id',
        'head_id'
    ];

    public function position(){
        $this->hasOne(Position::class);
    }

    public function avatar(){
        $this->hasOne(Position::class);
    }

    public function head(){
        $this->hasOne(Head::class);
    }

}
