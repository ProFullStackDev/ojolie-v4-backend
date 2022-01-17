<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    public $table = "payment_status";

    public static function payStatusOptions()
    {
        $options = Self::pluck('label','code')->toArray();
        return [''=>'-- Select Payment Status --'] + $options;
    }
}
