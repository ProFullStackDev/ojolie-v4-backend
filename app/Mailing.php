<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    //
    public $table = "mailing_list";
    protected $fillable = [

        'email'
    
        ];
}
