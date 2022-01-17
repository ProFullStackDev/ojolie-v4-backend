<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumSubscriptionType extends Model
{

    public $table = "premium_subscription_type";

    protected $fillable = [

        'subscription_type',

    ];

    public function premiumsubscriptiontype()
    {
        return $this->belongsTo('App\Price' ,'subscription_type');
    }

}
