<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcardCategory extends Model
{

    protected $table = 'ecard_categories';

    public function children()
    {
       return $this->hasMany(Self::class,'parent_id');
    }

    public function parent()
    {
       return $this->belongsTo(Self::class,'parent_id');
    }

    public static function options($parent = false)
    {
        if($parent)
        {
            $options = Self::whereNull('parent_id')->pluck('name','id')->prepend('--Please Select--','')->all();
        }
        else
        {
            $options = Self::whereNotNull('parent_id')->pluck('name','id')->prepend('--Please Select--','')->all();
        }
        return $options;
    }
}
