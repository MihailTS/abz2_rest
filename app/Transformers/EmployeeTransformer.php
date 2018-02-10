<?php

namespace App\Transformers;

use App\Employee;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
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
}
