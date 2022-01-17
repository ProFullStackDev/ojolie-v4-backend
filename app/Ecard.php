<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecard extends Model
{

    public function ecardcategories()
    {
        return $this->belongsToMany('App\EcardCategory','ecard_to_category','ecard_id','ecard_category_id')->withPivot(['type','sort']);
    }

    public function ecardcategory()
    {
        return $this->hasMany('App\EcardCategory');
    }

    public function ecardtocategory()
    {
        return $this->hasMany('App\EcardToCategory');
    }

    public function ecardtitles()
    {
        return $this->hasMany('App\EcardTitle');
    }

    public function draft_ecards()
    {
        return $this->hasMany('App\DraftEcards');
    }

    public function getFileName()
    {
        return explode('.',$this->filename)[0];
    }

    public function getThumbnail()
    {
        return $this->filename;
    }

    public function ecardsentitems()
    {
        return $this->hasMany('App\EcardsentItem');
    }
    public function ecardtocat()
    {
        return $this->hasMany('App\EcardToCategory');
    }
}
