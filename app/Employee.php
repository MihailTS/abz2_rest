<?php

namespace App;

use App\Transformers\EmployeeTransformer;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    public $transformer = EmployeeTransformer::class;

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
        self::deleting(function ($employee) {
            $subordinates = $employee->subordinates();
            $subordinates->update(['head_id' => $employee->head_id]);

            $employee->avatar->delete();
        });

        self::updating(function ($employee) {
            $employee->avatar->deleteFiles();
        });
    }

    public function getSalaryAttribute($value)
    {
        return number_format($value, '2', '.', ' ');
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function avatar(){
        return $this->belongsTo(Avatar::class);
    }

    public function head(){
        return $this->belongsTo(Employee::class, 'id', 'head_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'head_id', 'id');
    }

}
