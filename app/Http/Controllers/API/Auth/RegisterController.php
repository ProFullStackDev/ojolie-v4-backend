<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Member;
use App\Http\Resources\UserResource;
use App\Order;
use App\Libs\BraintreeAPI;
use App\Mail\AccountVerifyMail;
use App\Mail\FreeMemberActivateMail;
use App\Mail\PaidMemberMail;
use App\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\NewsletterSubscription;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
            'subscription_type' => 'required|numeric|in:1,2,101',
            'newsletter_subscribed' => 'required|numeric'
        ];

        $user = new User;

        if (in_array($request->subscription_type, [1, 2])) {
            $rules['payment_method'] = 'required';

            $rules['currency'] = 'required';
            $rules['amount'] = 'required|numeric';

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

            $user->active = 1;
        }

        $request->validate($rules);

        DB::beginTransaction();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $member = new Member;
        $member->user_id = $user->id;
        $member->country = $request->country ? strtoupper($request->country) : null;
        $member->notify_pickup = 1;
        $member->notify_sent = 0;
        $member->notify_reply = 0;
        $member->newsletter_subscribed = $request->newsletter_subscribed ? 1 : 0;
        $member->type = 0;
        $member->save();

        if (in_array($request->subscription_type, [1, 2])) {
            $order = new Order;
            $order->user_id = $user->id;
            $order->subscription_type = $request->subscription_type;
            $order->save();

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

                    $user->active = 1;
                    $user->save();

                    if ($request->subscription_type == 1) {
                        $expiry_date = Carbon::now()->addYears(1)->format('Y-m-d');
                    } else {
                        $expiry_date = Carbon::now()->addYears(2)->format('Y-m-d');
                    }

                    $member->type = 1;
                    $member->expires_at = $expiry_date;
                    $member->save();
                } else {
                    DB::rollBack();
                    return response()->json(['message' => $transaction->message], 402);
                }

            } else {
                $payment = new Payment;
                $payment->order_id = $order->id;
                $payment->pay_via = $request->payer_id;
                $payment->pay_via_type = 'Paypal';
                $payment->pay_currency = $request->currency;
                $payment->pay_amount = $request->amount;
                $payment->pay_date = date('Y-m-d H:i:s');
                $payment->pay_status = 1;
                $payment->pay_name = $request->first_name . ' ' . $request->last_name;
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

                    $user->active = 1;
                    $user->save();

                    if ($request->subscription_type == 1) {
                        $expiry_date = Carbon::now()->addYears(1)->format('Y-m-d');
                    } else {
                        $expiry_date = Carbon::now()->addYears(2)->format('Y-m-d');
                    }

                    $member->type = 1;
                    $member->expires_at = $expiry_date;
                    $member->save();
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
        }

        // $token = $user->createToken('token-name')->plainTextToken;

        DB::commit();

        if ($request->newsletter_subscribed == 1) {
            $newsletter_check = NewsletterSubscription::where('email', '=', $user->email)->count();
            if ($newsletter_check < 1) {
                $mailing = new NewsletterSubscription;
                $mailing->email = $request->email;
                $mailing->save();
                $mail_to = $request->email;
                Mail::to($mail_to)->queue(new \App\Mail\NewsletterConfirmationMail($mailing));
            }
        }

        if (in_array($request->subscription_type, [1, 2])) {
            Mail::to($member->user->email)
                ->queue(new PaidMemberMail($order));
        } else {
            Mail::to($user->email)
                ->queue(new FreeMemberActivateMail($user));
        }

        $message = 'success';

        return response()->json(['code' => '000', 'email' => $user->email, 'message' => $message, 'note' => 'Verify your account in email.']);
    }
}
