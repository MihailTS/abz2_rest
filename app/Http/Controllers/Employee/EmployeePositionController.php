<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use App\Http\Controllers\ApiController;

class EmployeePositionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        $position = $employee->position;

        return $this->showOne($position);
    }
}
