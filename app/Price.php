<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    public $table = "prices";

    protected $fillable = [

        'subscription_type',
        'currency',
        'currency_symbol',
        'amount'

    ];

    public function subscriptiontype()
    {
        return $this->belongsTo('App\SubscriptionType', 'subscription_type', 'code');
    }

    public function premiumsubscriptiontype()
    {
        return $this->belongsTo('App\PremiumSubscriptionType' ,'subscription_type');
    }
}
