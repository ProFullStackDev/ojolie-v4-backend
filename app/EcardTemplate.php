<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcardTemplate extends Model
{
    //
    public $table = "ecard_template";
    protected $fillable = [

        'template_name',
        'template_title',
        'template_content',
        'mb_template_title',
        'mb_template_content',
        'default',
        'ecard_id'

        ];
}
