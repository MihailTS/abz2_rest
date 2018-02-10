<?php

namespace App;

use App\Transformers\PositionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    public $transformer = PositionTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name'];

    public function employees(){
        $this->belongsToMany(Employee::class);
    }
}
