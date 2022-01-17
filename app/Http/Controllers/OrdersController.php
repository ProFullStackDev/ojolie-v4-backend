<?php

namespace App\Http\Controllers;

use App\Libs\Helper;
use App\Order;
use App\Payment;
use App\PaymentStatus;
use App\SubscriptionType;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['subscription_types'] = SubscriptionType::options();
        $data['payment_status'] = PaymentStatus::payStatusOptions();
        $data['pay_via_types'] = Helper::payViaTypeOptions();
        $data['currencies'] = Helper::currencyOptions();
        $data['user_id'] = $request->user_id;
        return view('orders.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'subscription_type'=>'required',
            'pay_via_type'=>'required',
            'pay_via'=>'required',
            'pay_currency'=>'required',
            'pay_amount'=>'required|numeric',
            'pay_status'=>'required',
            'pay_name'=>'required',
            'pay_email'=>'required',
            'transaction_id'=>'',
            'pay_date'=>'required'
        ];

        $this->validate($request,$rules);

        $order = new Order;
        $order->user_id = $request->user_id;
        $order->subscription_type = $request->subscription_type;
        $order->save();

        $payment = new Payment;
        $payment->order_id = $order->id;
        $payment->pay_via = $request->pay_via;
        $payment->pay_via_type = $request->pay_via_type;
        $payment->pay_currency = $request->pay_currency;
        $payment->pay_amount = $request->pay_amount;
        $payment->pay_date = date('Y-m-d H:i:s',strtotime($request->pay_date));
        $payment->pay_status = $request->pay_status;
        $payment->pay_name = $request->pay_name;
        $payment->pay_email = $request->pay_email;
        $payment->transaction_id = $request->transaction_id;
        $payment->save();

        return redirect()->back()->with('success','Order & payment created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['subscription_types'] = SubscriptionType::options();
        $data['payment_status'] = PaymentStatus::payStatusOptions();
        $data['pay_via_types'] = Helper::payViaTypeOptions();
        $data['currencies'] = Helper::currencyOptions();
        $data['order'] = Order::find($id);
        return view('orders.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'subscription_type'=>'required',
            'pay_via_type'=>'required',
            'pay_via'=>'required',
            'pay_currency'=>'required',
            'pay_amount'=>'required|numeric',
            'pay_status'=>'required',
            'pay_name'=>'required',
            'pay_email'=>'required',
            'transaction_id'=>'',
            'pay_date'=>'required'
        ];

        $this->validate($request,$rules);

        $order = Order::find($id);
        $order->subscription_type = $request->subscription_type;
        $order->save();

        $payment = $order->payment;
        $payment->order_id = $order->id;
        $payment->pay_via = $request->pay_via;
        $payment->pay_via_type = $request->pay_via_type;
        $payment->pay_currency = $request->pay_currency;
        $payment->pay_amount = $request->pay_amount;
        $payment->pay_date = date('Y-m-d H:i:s',strtotime($request->pay_date));
        $payment->pay_status = $request->pay_status;
        $payment->pay_name = $request->pay_name;
        $payment->pay_email = $request->pay_email;
        $payment->transaction_id = $request->transaction_id;
        $payment->save();

        return redirect()->back()->with('success','Order & payment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $order = Order::find($id);
            $order->payment->delete();
            $order->delete();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return redirect()->back()->with('error',$e->errorInfo[2]);
        }
        return redirect()->back()->with('success', 'Order & payment deleted.');
    }
}
