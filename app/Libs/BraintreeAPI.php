<?php

namespace App\Libs;

class BraintreeAPI
{
    public static function execute($request)
    {
        $braintree = config('braintree');

        if($request->currency == '$'){
            $merchantAccountId = 'OjolieUSD';
        }else if($request->currency == '€'){
            $merchantAccountId = 'OjolieEUR';
        }else if($request->currency == '£'){
            $merchantAccountId = 'OjolieGBP';
        }else{
            $merchantAccountId = 'OjolieUSD';
        }

        $card_expiration_year = strlen($request->card_expiration_year) == 2 ? '20'.$request->card_expiration_year : $request->card_expiration_year;

        $result = $braintree->transaction()->sale([
            'amount' => $request->amount,
            'merchantAccountId' => $merchantAccountId,
            'creditCard' =>
                array(
                    'number' => $request->card_number,
                    'cardholderName' => $request->card_name,
                    'expirationDate' => $request->card_expiration_month.'/'.$card_expiration_year,
                    'cvv' => $request->card_ccv
                ),
            'customFields' => [
                'user_email' => $request->email
            ],
            'options' => [
                    'submitForSettlement' => True
                ]
        ]);

        return $result;
    }
}
