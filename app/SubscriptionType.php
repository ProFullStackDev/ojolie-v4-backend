<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    public static function options()
    {
        $options = Self::pluck('label','code')->toArray();
        return [''=>'-- Please Select --'] + $options;
    }
}
