<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EcardsentItem;
use App\EcardsentRecipient;
use App\Http\Resources\EcardsentItemResource;
use App\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class EcardpickupController extends Controller
{
    public function index($ecardsent_recipient_id)
    {
        $ecardsent_recipient_id = decrypt($ecardsent_recipient_id);

        $temp = explode('_',$ecardsent_recipient_id);
        $type = $temp[0];
        $type_id = $temp[1];

        if($type == 's')
        {
            $ecardsentitem = EcardsentItem::find($type_id);
        }
        else
        {
            $ecardsentrecipient = EcardsentRecipient::find($type_id);
            $ecardsentrecipient->count_view+=1;
            $ecardsentrecipient->pickup_date = date('Y-m-d H:i:s');
            $ecardsentrecipient->save();

            $ecardsentitem = EcardsentItem::with(['ecardsentrecipients'=>function($query)use($type_id){
                $query->where('id',$type_id);
            }])->find($ecardsentrecipient->ecardsent_item_id);
        }

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'pickup_recipient_id' => $type_id,
                'response' => new EcardsentItemResource($ecardsentitem),
                'message' => $message
            ],
        ]);

    }

    public function redirectPickup($ecardsent_recipient_id)
    {
        $url = "https://staging-ojolie-frontend-pfylq.ondigitalocean.app/card-pickup/$ecardsent_recipient_id";

        return redirect($url);

    }

    public function reply(Request $request)
    {
        $rules = [
            'ecardsent_recipient_id'=>'required',
            'message'=>'required'
        ];

        $request->validate($rules);

        $ecardsent_recipient_id = $request->ecardsent_recipient_id;

        $ecardsentrecipient = EcardsentRecipient::find($ecardsent_recipient_id);

        $ecardsentrecipient->ecardsentreply()->create(['message'=>$request->message]);

        $ecardsentitem = EcardsentItem::with(['ecardsentrecipients'=>function($query)use($ecardsent_recipient_id){
            $query->where('id',$ecardsent_recipient_id);
        }])->find($ecardsentrecipient->ecardsent_item_id);

        $ecardSender = User::find($ecardsentitem->user_id);

        if ($ecardsentitem->pickup_noti == 1) {

            $mail_to = $ecardSender->email;

            $sender_message = $request->message;

            $reply_email = $ecardsentrecipient->email;

            Mail::to($mail_to)->send(new \App\Mail\PickupReplyMail($reply_email, $sender_message));

        }

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new EcardsentItemResource($ecardsentitem),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);

    }
}
