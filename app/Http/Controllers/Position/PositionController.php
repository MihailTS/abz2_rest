<?php

namespace App\Http\Controllers\Position;

use App\Position;
use App\Transformers\PositionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PositionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . PositionTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();

        return $this->showAll($positions);
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
            'name' => 'required|unique:positions'
        ];
        $this->validate($request, $rules);

        $data = $request->all();

        $position = Position::create($data);

        return $this->showOne($position, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Position $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return $this->showOne($position);
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
     * @param  Position $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $rules = [
            'name' => 'unique:positions'
        ];
        $this->validate($request, $rules);

        if ($request->has('name')) {
            $position->name = $request->name;
        }

        if (!$position->isDirty()) {
            return $this->errorResponce('Данные должны отличаться', 422);
        }

        $position->save();

        return $this->showOne($position);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Position $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return $this->showOne($position);

    }
}
