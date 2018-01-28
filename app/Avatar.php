<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = [
        'hashName'
    ];

    public function employee(){
        $this->belongsTo(Employee::class);
    }

}
