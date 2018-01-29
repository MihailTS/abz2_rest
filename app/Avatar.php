<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = [
        'path',
        'thumbnail'
    ];

    public function employee(){
        $this->belongsTo(Employee::class);
    }

    public function createThumbnail()
    {
        //todo
    }

}
