<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use App\Http\Controllers\ApiController;

class EmployeeHeadController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        $head = $employee->head;

        return $this->showOne($head);
    }
}
