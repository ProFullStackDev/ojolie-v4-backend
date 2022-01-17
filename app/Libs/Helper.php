<?php

namespace App\Libs;

class Helper
{
    public static function timezoneOptions()
    {
        $timezones = timezone_identifiers_list();
        $timezones = array_combine($timezones,$timezones);

        return [''=>'--Please Select--'] + $timezones;
    }

    public static function payViaTypeOptions()
    {
        return [
            '' => '--Please Select--',
            'Braintree' => 'Braintree',
            'Paypal' => 'Paypal'
        ];
    }

    public static function currencyOptions()
    {
        return [
            '' => '--Please Select--',
            'USD' => 'USD',
            'EUR' => 'EUR',
            'GBP' => 'GBP'
        ];
    }
}