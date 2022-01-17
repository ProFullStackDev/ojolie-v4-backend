<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DraftEcards extends Model
{
    public $table = 'draft_ecards';

    protected $fillable = [

        'active',
        'private',
        'popular_card',
        'recommended_card',
        'filename',
        'thumbnail',
        'caption',
        'detail',
        'video'

    ];

    public function ecard()
    {
        return $this->belongsTo('App\Ecard');
    }

    public function ecardtitles()
    {
        return $this->hasMany('App\EcardTitle');
    }

    public function getFileName()
    {
        return explode('.', $this->filename)[0];
    }

    public function ecardcategories()
    {
        return $this->belongsToMany('App\EcardCategory', 'ecard_to_category', 'ecard_id', 'ecard_category_id')->withPivot(['type', 'sort']);
    }
}
