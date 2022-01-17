<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\FavouriteEcard;
use App\Http\Resources\EcardResource;
use App\Libs\BraintreeAPI;
use App\Mail\RenewMail;
use App\NewsletterSubscription;
use App\Order;
use App\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index()
    {
        return new UserResource(auth()->user());
    }


    public function update(Request $request, $type)
    {
        $user = auth()->user();
        if ($type == 'name') {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required'
            ];

            $request->validate($rules);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();
        }

        if ($type == 'email') {
            $rules = [
                'email' => 'required|email|max:30|unique:users,email,' . $user->id
            ];

            $request->validate($rules);
            $user->email = $request->email;
            $user->save();
        }

        if ($type == 'password') {
            $rules = [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed'
            ];

            $request->validate($rules);

            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
            } else {
                return response()->json(['message' => 'Invalid current password!'], 401);
            }
        }

        if ($type == 'timezone') {
            $rules = [
                'timezone' => 'required|timezone'
            ];

            $request->validate($rules);
            $user->member->timezone = $request->timezone;
            $user->member->save();
        }

        if ($type == 'notifications') {
            $rules = [
                'notify_pickup' => 'required|boolean',
                'notify_sent' => 'required|boolean',
                'notify_reply' => 'required|boolean',
                'newsletter_subscribed' => 'required|boolean'
            ];

            $request->validate($rules);
            $user->member->notify_pickup = $request->notify_pickup;
            $user->member->notify_sent = $request->notify_sent;
            $user->member->notify_reply = $request->notify_reply;
            $user->member->newsletter_subscribed = $request->newsletter_subscribed;
            $user->member->save();

            if ($request->newsletter_subscribed == 0) {
                NewsletterSubscription::where('email', $user->email)->first()->delete();
            }
        }

        if ($type == 'all') {
            $rules = [
                'first_name' => '',
                'last_name' => '',
                'email' => 'email|max:30|unique:users,email,' . $user->id,
                'timezone' => 'timezone',
                'notify_pickup' => 'boolean',
                'notify_sent' => 'boolean',
                'notify_reply' => 'boolean',
                'newsletter_subscribed' => 'boolean'
            ];

            $request->validate($rules);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();

            if ($request->newsletter_subscribed == 0) {
                $newsletter_check = NewsletterSubscription::where('email', '=', $user->email)->count();
                if($newsletter_check == 1){
                    NewsletterSubscription::where('email', $user->email)->first()->delete();
                }

            } elseif ($request->newsletter_subscribed == 1) {
                $newsletter_check = NewsletterSubscription::where('email', '=', $user->email)->count();
                if($newsletter_check < 1) {
                    $mailing = new NewsletterSubscription;
                    $mailing->email = $request->email;
                    $mailing->save();
                    $mail_to = $mailing->email;
                    Mail::to($mail_to)->queue(new \App\Mail\NewsletterConfirmationMail($mailing));
                }
            }

            $user->member->timezone = $request->timezone;
            $user->member->notify_pickup = $request->notify_pickup;
            $user->member->notify_sent = $request->notify_sent;
            $user->member->notify_reply = $request->notify_reply;
            $user->member->newsletter_subscribed = $request->newsletter_subscribed;
            $user->member->save();
        }

        $message = "success";

        return response([
            'data' => [
                'code' => '000',
                'response' => new UserResource($user),
                'message' => $message
            ],
        ], Response::HTTP_ACCEPTED);
    }

    public function togglefavourite($ecard_id)
    {
        $favourite_ecard = FavouriteEcard::where('ecard_id', $ecard_id)->where('user_id', auth()->user()->id)->first();
        if (is_null($favourite_ecard)) {
            $favourite_ecard = new FavouriteEcard;
            $favourite_ecard->user_id = auth()->user()->id;
            $favourite_ecard->ecard_id = $ecard_id;
            $favourite_ecard->save();
            $message = 'Favourite card added!';
        } else {
            $favourite_ecard->delete();
            $message = 'Removed from favourite cards!';
        }

        return response()->json(['message' => $message], 200);
    }

    public function favouritecards()
    {
        return EcardResource::collection(auth()->user()->favouritecards);
    }

    public function checkfavourite($ecard_id)
    {
        $favourite_ecard_check = auth()->user()->favouritecards()->where('ecards.id', $ecard_id)->exists();
        return response()->json(['favorite_status' => $favourite_ecard_check]);
    }

    public function renew(Request $request)
    {
        $rules = [
            'subscription_type' => 'required|numeric|in:1,2,11,12',
            'currency' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required'
        ];

        if ($request->payment_method == 'Braintree') {
            $rules['card_number'] = 'required';
            $rules['card_name'] = 'required';
            $rules['card_expiration_month'] = 'required|numeric';
            $rules['card_expiration_year'] = 'required|numeric';
            $rules['card_ccv'] = 'required|numeric';
        } else {
            $rules['payer_id'] = 'required';
            $rules['payment_id'] = 'required';
            $rules['payer_email'] = 'required';
            $rules['encrypted_data'] = 'required';
        }

        $request->validate($rules);

        $order = auth()->user()->orders()->latest()->first();
        $member = auth()->user()->member;

        // if (!is_null($order)) {
        //     $last_payment_date = Carbon::parse($order->payment->pay_date);
        //     $now = Carbon::now();
        //     $diff = $now->diffInDays($last_payment_date);

        //     if ($diff == 0) {
        //         return response()->json(['message' => 'New payment exists already!'], 403);
        //     }
        // }

        if ($request->payment_method == 'Braintree') {
            $braintree = config('braintree');

            if ($request->currency == "EUR") {
                $merchantAccountId = 'OjolieEUR';
            } elseif ($request->currency == "USD") {
                $merchantAccountId = 'OjolieUSD';
            } elseif ($request->currency == "GBP") {
                $merchantAccountId = 'OjolieGBP';
            } elseif ($request->currency == "DKK") {
                $merchantAccountId = 'OjolieDKK';
            }

            $transaction = $braintree->transaction()->sale([
                'amount' => $request->amount,
                'merchantAccountId' => $merchantAccountId,
                'creditCard' =>
                array(
                    'number' => $request->card_number,
                    'cardholderName' => $request->card_name,
                    'expirationDate' => $request->card_expiration_month . '/' . $request->card_expiration_year,
                    'cvv' => $request->card_ccv
                ),
                'customFields' => [
                    'user_id' => auth()->user()->id,
                    'user_email' => auth()->user()->email
                ],
                'options' => [
                    'submitForSettlement' => True
                ]
            ]);

            if ($transaction->success) {
                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->subscription_type = $request->subscription_type;
                $order->save();

                $payment = new Payment;
                $payment->order_id = $order->id;
                $payment->pay_via = $transaction->transaction->creditCard['cardType'];
                $payment->pay_via_type = 'Braintree';
                $payment->pay_currency = $transaction->transaction->currencyIsoCode;
                $payment->pay_amount = $transaction->transaction->amount;
                $payment->pay_date = date('Y-m-d H:i:s', date_timestamp_get($transaction->transaction->createdAt));
                $payment->pay_status = 1;
                $payment->pay_name = $transaction->transaction->creditCard['cardholderName'];
                $payment->pay_email = $request->email;
                $payment->transaction_id = $transaction->transaction->id;
                $payment->save();

                $from_date = $member->expires_at ? Carbon::parse($member->expires_at) : Carbon::now();

                if ($request->subscription_type == 1) {
                    $expiry_date = $from_date->addYears(1)->format('Y-m-d');
                } elseif ($request->subscription_type == 2) {
                    $expiry_date = $from_date->addYears(2)->format('Y-m-d');
                } elseif ($request->subscription_type == 11) {
                    $expiry_date = $from_date->addYears(1)->format('Y-m-d');
                } elseif ($request->subscription_type == 12) {
                    $expiry_date = $from_date->addYears(2)->format('Y-m-d');
                }
                $member->type = 1;
                $member->expires_at = $expiry_date;
                $member->save();

                Mail::to($member->user->email)
                    ->queue(new RenewMail($order));

            } else {
                return response()->json(['message' => $transaction->message], 402);
            }

        } else {

            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->subscription_type = $request->subscription_type;
            $order->save();

            $payment = new Payment;

            $payment->order_id = $order->id;
            $payment->pay_via = $request->payer_id;
            $payment->pay_via_type = 'Paypal';
            $payment->pay_currency = $request->currency;
            $payment->pay_amount = $request->amount;
            $payment->pay_date = date('Y-m-d H:i:s');
            $payment->pay_status = 1;
            $payment->pay_name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $payment->pay_email = $request->payer_email;


            $key = "113223112113213gaega342323t42fda";
            $aesDecrypt_id = openssl_decrypt(
                base64_decode($request->encrypted_data),
                "aes-256-ecb",
                $key,
                OPENSSL_RAW_DATA
            );

            if($aesDecrypt_id == $request->payment_id) {

                $payment_id_check = Payment::where('transaction_id', $aesDecrypt_id)->count();
                if ($payment_id_check == 0) {
                    $payment->transaction_id = $aesDecrypt_id;
                    $payment->save();

                    $from_date = $member->expires_at ? Carbon::parse($member->expires_at) : Carbon::now();

                    if ($request->subscription_type == 1) {
                        $expiry_date = $from_date->addYears(1)->format('Y-m-d');
                    } elseif ($request->subscription_type == 2) {
                        $expiry_date = $from_date->addYears(2)->format('Y-m-d');
                    } elseif ($request->subscription_type == 11) {
                        $expiry_date = $from_date->addYears(1)->format('Y-m-d');
                    } elseif ($request->subscription_type == 12) {
                        $expiry_date = $from_date->addYears(2)->format('Y-m-d');
                    }
                    $member->type = 1;
                    $member->expires_at = $expiry_date;
                    $member->save();

                    Mail::to($member->user->email)
                        ->queue(new RenewMail($order));
                } else {
                    return response()->json([
                        'code' => '400',
                        'message' => 'Payment was failed. Please pay in paypal first.'
                    ]);
                }
            } elseif ($aesDecrypt_id != $request->payment_id) {
                return response()->json([
                    'code' => '400',
                    'message' => 'Payment was failed. Please pay in paypal first.'
                ]);
            }

        }

        $message = 'Subscriptions updated!';

        return response()->json([
            'code' => '000',
            'message' => $message
        ], Response::HTTP_CREATED);
    }
}
