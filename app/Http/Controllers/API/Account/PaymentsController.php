<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment;
use App\Http\Resources\PaymentResource;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('order',function($query){
            $query->where('user_id',auth()->user()->id);
        })->orderBy('id','DESC')->get();

        return PaymentResource::collection($payments);
    }

    public function last_payment()
    {
        $payments = Payment::orderBy('id','DESC')->first();

        return PaymentResource::collection($payments);
    }
}
