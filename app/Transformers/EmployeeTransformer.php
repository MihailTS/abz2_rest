<?php

namespace App\Transformers;

use App\Employee;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    private static $attributesMap = [
        'id' => "id",
        'name' => "name",
        'salary' => "salary",
        'employmentDate' => "employmentDate",
        'position' => "position_id",
        'avatar' => "avatar_id",
        'head' => "head_id",
        'createdTime' => "created_at",
        'lastModifiedTime' => "modified_at",
        'deletedTime' => "deleted_at",
    ];
    /**
     * A Fractal transformer.
     *
     * @param Employee $employee
     * @return array
     */
    public function transform(Employee $employee)
    {
        return [
            'id' => (int)$employee->id,
            'name' => (string)$employee->name,
            'salary' => (float)$employee->salary,
            'employmentDate' => (string)$employee->employmentDate,
            'position' => (int)$employee->position_id,
            'avatar' => isset($employee->avatar) ? (string)Storage::disk("avatars")->url($employee->avatar->path) : null,
            'head' => isset($employee->head_id) ? (int)$employee->head_id : null,
            'createdTime' => (string)$employee->created_at,
            'lastModifiedTime' => isset($employee->modified_at) ? (string)$employee->modified_at : null,
            'deletedTime' => isset($employee->deleted_at) ? (string)$employee->deleted_at : null
        ];
    }

    public static function getOriginalAttributeName($index)
    {
        return isset(self::$attributesMap[$index]) ? self::$attributesMap[$index] : null;
    }
}
