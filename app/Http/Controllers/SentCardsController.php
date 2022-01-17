<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EcardsentItem;

class SentCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sentcards.index');
    }

    public function datasource(Request $request)
    {
        $columns = array(
                    0 => 'id',
                    1 => 'card',
                    2 => 'delivery',
                    3 => 'message'
                );

        $totalData = EcardsentItem::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $sentcards = EcardsentItem::withTrashed()->where(function($query)use($request){
            if($request->user_id)
                $query->where('user_id',$request->user_id);
            if($request->from_email)
            {
                $query->whereHas('user',function($query)use($request){
                    $query->where('email',$request->from_email);
                });
            }
            if($request->to_email)
            {
                $query->whereHas('ecardsentrecipients',function($query)use($request){
                    $query->where('email',$request->to_email);
                });
            }
        })->offset($start)->limit($limit)->orderBy($order,$dir)->get();

        $totalFiltered = EcardsentItem::withTrashed()->where(function($query)use($request){
            if($request->user_id)
                $query->where('user_id',$request->user_id);
            if($request->from_email)
            {
                $query->whereHas('user',function($query)use($request){
                    $query->where('email',$request->from_email);
                });
            }
            if($request->to_email)
            {
                $query->whereHas('ecardsentrecipients',function($query)use($request){
                    $query->where('email',$request->to_email);
                });
            }
        })->count();
        //======================

        $data = array();
        if(!empty($sentcards))
        {
            foreach ($sentcards as $sentcard)
            {
                $show =  route('sentcards.detail',$sentcard->id);
                //$edit =  route('ecards.edit',$ecard->id);
                //$delete = route('ecards.destroy',$ecard->id);

                $right = '<i class="fa fa-check text-success"><i/>';
                $wrong = '<i class="fa fa-remove text-danger"><i/>';

                $recipients = $sentcard->ecardsentrecipients;
                $card = 'Card ID: '.$sentcard->ecard->id.'<br/>';
                $card .= 'Card Name: '.$sentcard->ecard->getFileName().'<br/>';
                $card .= 'Card Thumbnail: <br/>';
                $card .= '<img src="' . asset('storage/img/ecards/' . $sentcard->ecard->filename . '.jpg') . '" width="70"/>';

                $delivery = 'Status: '.$sentcard->deliveryStatus().'<br/>';
                $delivery .= 'Created At: '.$sentcard->created_at.'<br/>';
                if ($sentcard->deliveryStatus() == 'Sent') {
                    $delivery .= 'Send Date: '.$sentcard->sentDate().'<br/>';
                }
                $delivery .= 'Delete Date: '.$sentcard->deleted_at ? $sentcard->deleted_at : 'No';

                $message = 'From Name: '.$sentcard->user->getFullName().'<br/>';
                $message .= 'From Email: '.$sentcard->user->email.'<br/>';
                $message .= 'Email Subject: '.$sentcard->user->getFullName().' has sent you a card.<br/>';

                if ($sentcard->email_message != null){
                    $message .= 'Email Message: '.$sentcard->user->getFullName().' ('.$sentcard->user->email.')'.' has sent you a card.<br/>'.$sentcard->email_message;
                } elseif  ($sentcard->email_message == null){
                    $message .= 'Email Message: '.$sentcard->user->getFullName().' ('.$sentcard->user->email.')'.' has sent you a card.<br/>';
                }

                $nestedData['id'] = $sentcard->id;
                $nestedData['card'] = $card;
                $nestedData['delivery'] = $delivery;
                $nestedData['message'] = $message;
                $nestedData['recipients'] = $recipients;

                $nestedData['options'] ="<div class='btn-group'>";
                $nestedData['options'] .= "<a href='{$show}' title='Show' class='btn btn-default btn-xs'><i class='fa fa-info-circle'></i></a>";
                $nestedData['options'].="</div>";

                $data[] = $nestedData;

            }
        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );

        return json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sentCardDetail = EcardsentItem::find($id);

        $delivery = 'Status: '.$sentCardDetail->deliveryStatus().'<br/>';
        $delivery .= 'Created At: '.$sentCardDetail->created_at.'<br/>';
        if ($sentCardDetail->deliveryStatus() == 'Sent') {
            $delivery .= 'Send Date: '.$sentCardDetail->sentDate().'<br/>';
        }
        $delivery .= 'Delete Date: '.$sentCardDetail->deleted_at ? $sentCardDetail->deleted_at : 'No';

        $message = 'From Name: '.$sentCardDetail->user->getFullName().'<br/>';
        $message .= 'From Email: '.$sentCardDetail->user->email.'<br/>';
        $message .= 'Email Subject: '.$sentCardDetail->user->getFullName().' has sent you a card.<br/>';

        if ($sentCardDetail->email_message != null){
            $message .= 'Email Message: '.$sentCardDetail->user->getFullName().' ('.$sentCardDetail->user->email.')'.' has sent you a card.<br/>'.$sentCardDetail->email_message;
        } elseif  ($sentCardDetail->email_message == null){
            $message .= 'Email Message: '.$sentCardDetail->user->getFullName().' ('.$sentCardDetail->user->email.')'.' has sent you a card.<br/>';
        }

        $recipients = $sentCardDetail->ecardsentrecipients;

        return view('sentcards.detail', compact('sentCardDetail', 'recipients', 'message', 'delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
