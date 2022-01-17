<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeDynamicCards extends Model
{
    //
    public $table = "dynamic_3_cards";
    protected $fillable = [

        'name',
        'card_title',
        'card_content',
        'card_img',
        'card_link',
        'bg_color',
        'category_id'

        ];
}
