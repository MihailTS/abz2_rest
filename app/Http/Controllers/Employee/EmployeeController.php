<?php

namespace App\Http\Controllers\Employee;

use App\Avatar;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class EmployeeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        return $this->showAll($employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'salary' => 'required|numeric',
            'employmentDate' => 'required|date',
            'head_id' => 'integer|exists:employees,id',
            'position_id' => 'required|integer|exists:positions,id',
            'avatar' => 'image'
        ];
        $this->validate($request, $rules);

        $data = $request->all();

        $data['avatar_id']=Avatar::create([
            "path"=>$request->avatar->store()
        ])->id;

        $employee = Employee::create($data);

        return $this->showOne($employee, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return $this->showOne($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'salary' => 'numeric',
            'employmentDate' => 'date',
            'head_id' => 'integer|exists:employees,id',
            'position_id' => 'integer|exists:positions,id',
            'avatar' => 'image'
        ];
        $this->validate($request, $rules);

        if($request->has('name')){
            $employee->name = $request->name;
        }
        if($request->has('salary')){
            $employee->salary = $request->salary;
        }
        if($request->has('employmentDate')){
            $employee->employmentDate = $request->employmentDate;
        }
        if($request->has('head_id')){
            $employee->head_id = $request->head_id;
        }
        if($request->has('position_id')){
            $employee->position_id = $request->position_id;
        }
        if($request->has('avatar')){

            $avatar=Avatar::create([
                "path" => $request->avatar->store()
            ]);
            $employee->avatar_id = $avatar->id;
        }

        if(!$employee->isDirty()){
            return $this->errorResponce('Данные должны отличаться', 422);
        }

        $employee->save();

        return $this->showOne($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return $this->showOne($employee);
    }
}
