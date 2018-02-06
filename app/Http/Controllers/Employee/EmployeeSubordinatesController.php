<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class EmployeeSubordinatesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        $subordinates=$employee->subordinates;

        return $this->showAll($subordinates);
    }
}
