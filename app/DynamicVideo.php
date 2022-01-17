<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DynamicVideo extends Model
{
    //
    public $table = "dynamic_video";
    protected $fillable = [

        'video',

        ];
}
