<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
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


    /**
     * Меняет руководителя текущего пользователя на другого
     * @param Employee $head новый руководитель
     * @return bool
     * @throws Exception если новый начальник является подчиненным сотрудника
     */
    public function changeHead(Employee $head)
    {
        $result = false;
        if (!is_null($head)) {
            if ($this->isHeadOf($head)) {
                throw new Exception('parent');//todo: заменить исключение
            } else {
                $this->head_id = $head->id;
                $result = $this->save();
            }
        }
        return $result;
    }

    public static function boot()
    {
        parent::boot();

        //при удалении сотрудника все его подчиненные переходят к вышестоящему начальнику
        self::deleting(function ($value) {
            $subordinates = $value->subordinates();
            $subordinates->update(['head_id' => $value->head_id]);
        });
    }

    public function getSalaryAttribute($value)
    {
        return number_format($value, '2', '.', ' ');
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
        return $this->hasMany(Employee::class, 'head_id', 'id');
    }

}
