<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
     * @param $subordinate
     * @return bool true, если $subordinate является непосредственным или косвенным подчиненным
     */
    public function isHeadOf(Employee $subordinate)
    {
        $result = false;
        $currentEmployee = $subordinate;
        while ($currentEmployee = $currentEmployee->head) {
            if ($currentEmployee->id === $this->id) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    public function position(){
        return $this->hasOne(Position::class);
    }

    public function avatar(){
        return $this->hasOne(Position::class);
    }

    public function head(){
        return $this->hasOne(Employee::class, 'id', 'head_id');
    }

    public function subordinates()
    {
        return $this->belongsToMany(Employee::class, 'head_id');
    }

}
