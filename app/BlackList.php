<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    //
    public $table = "black_list";
    protected $fillable = [

        'email'

        ];
}
