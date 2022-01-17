<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    public function typereference()
    {
        return $this->morphOne('App\Reference', 'referable',null,'referable_id','type');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
