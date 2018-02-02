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


    /**
     * @param $employee
     * @return bool true, если $employee является непосредственным или косвенным начальником
     */
    public function isSupreme($employee)
    {//
        $result = false;
        $currentHead = $employee;
        while ($currentHead = $currentHead->head()->first()) {
            if ($currentHead->id == $this->id) {
                $result = true;
                break;
            }
        }
        return $result;
    }

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
