<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    //
    public $table = "contact_messages";
    protected $fillable = [

        'name',
        'email',
        'message'
    
        ];
}
