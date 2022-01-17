<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcardToCategory extends Model
{
    protected $table = 'ecard_to_category';

    public $fillable = ['ecard_id','ecard_category_id', 'card_caption','type'];

    public function ecard()
    {
        return $this->belongsTo('App\Ecard');
    }

    public function draft_ecard()
    {
        return $this->belongsTo('App\DraftEcard');
    }
}
