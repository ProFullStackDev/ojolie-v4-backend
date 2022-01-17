<?php

namespace App\Http\Controllers\API\Product;

use App\BlackList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EcardsentItem;
use App\Http\Resources\EcardsentItemResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\CardSendMail;
use App\Mail\PickupNotiMail;
use Symfony\Component\HttpFoundation\Response;

class EcardsentItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type == 'sent') {
            $ecardsentitems = EcardsentItem::userScope()->with('ecardsentrecipients')->where('draft', 0)->orderBy('id', 'DESC')->paginate(3);
        } elseif ($request->type == 'drafted') {
            $ecardsentitems = EcardsentItem::userScope()->with('ecardsentrecipients')->where('draft', 1)->orderBy('id', 'DESC')->paginate(3);
        } elseif ($request->type == 'received') {
            $ecardsentitems = EcardsentItem::userScope()->with('ecardsentrecipients')->whereHas('ecardsentrecipients', function ($query) {
                $query->where('count_view', '>', 0);
            })->orderBy('id', 'DESC')->paginate(3);
        } else {
            $ecardsentitems = EcardsentItem::userScope()->with('ecardsentrecipients')->orderBy('id', 'DESC')->paginate(3);
        }

        return EcardsentItemResource::collection($ecardsentitems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_draft(Request $request)
    {
        $rules = [
            'ecard_id' => 'required|numeric',
            'greeting' => 'required',
            'draft' => 'required',
            'message' => 'required',
            'pickup_noti' => 'boolean',
            'timezone' => 'timezone',
        ];

        $request->validate($rules);

        $ecardsentitem = new EcardsentItem;
        $ecardsentitem->user_id = auth()->user()->id;
        $ecardsentitem->ecard_id = $request->ecard_id;
        $ecardsentitem->greeting = $request->greeting;
        $ecardsentitem->message = $request->message;
        $ecardsentitem->pickup_noti = $request->pickup_noti;
        $ecardsentitem->email_message = $request->email_message;
        $ecardsentitem->timezone = $request->timezone;

        if ($request->scheduled_date)
            $ecardsentitem->scheduled_date = date('Y-m-d H:i:s', strtotime($request->scheduled_date));

        if ($request->draft)
            $ecardsentitem->draft = 1;

        $ecardsentitem->save();

        $message = "success";

        return response([
            'data' => [
                'code' => '000',
                'response' => new EcardsentItemResource($ecardsentitem),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    public function update_draft(Request $request, $id)
    {
        $rules = [
            'ecard_id' => 'numeric',
            'greeting' => 'required',
            'draft' => 'required',
            'message' => 'required',
            'pickup_noti' => 'boolean',
            'timezone' => 'timezone',
        ];

        $request->validate($rules);

        $ecardsentitem = EcardsentItem::find($id);
        $ecardsentitem->user_id = auth()->user()->id;
        $ecardsentitem->ecard_id = $request->ecard_id;
        $ecardsentitem->greeting = $request->greeting;
        $ecardsentitem->message = $request->message;
        $ecardsentitem->pickup_noti = $request->pickup_noti;
        $ecardsentitem->email_message = $request->email_message;
        $ecardsentitem->timezone = $request->timezone;

        if ($request->scheduled_date)
            $ecardsentitem->scheduled_date = date('Y-m-d H:i:s', strtotime($request->scheduled_date));

        if ($request->draft)
            $ecardsentitem->draft = 1;

        $ecardsentitem->save();

        $message = "success";

        return response([
            'data' => [
                'code' => '000',
                'response' => new EcardsentItemResource($ecardsentitem),
                'message' => $message
            ],
        ], Response::HTTP_ACCEPTED);
    }

    public function store(Request $request)
    {
        $rules = [
            'ecard_id' => 'required|numeric',
            'greeting' => 'required',
            'message' => 'required',
            'pickup_noti' => 'boolean',
            'timezone' => 'timezone',
        ];

        if (!$request->draft) {
            //$rules['scheduled_date'] = 'required';
            $rules['recipients'] = 'required|array';
        }

        if ($request->recipients) {
            $rules['recipients.*.name'] = 'required';
            $rules['recipients.*.email'] = 'required|email';
        }

        $request->validate($rules);

        $ecardsentitem = new EcardsentItem;
        $ecardsentitem->user_id = auth()->user()->id;
        $ecardsentitem->ecard_id = $request->ecard_id;
        $ecardsentitem->greeting = $request->greeting;
        $ecardsentitem->message = $request->message;
        $ecardsentitem->pickup_noti = $request->pickup_noti;
        $ecardsentitem->email_message = $request->email_message;
        $ecardsentitem->timezone = $request->timezone;

        if ($request->scheduled_date)
            $ecardsentitem->scheduled_date = date('Y-m-d H:i:s', strtotime($request->scheduled_date));

        if ($request->draft)
            $ecardsentitem->draft = 1;

        $ecardsentitem->save();

        $ecardsentitem->ecardsentrecipients()->createMany($request->recipients);

        if ($ecardsentitem->draft == 0 && is_null($ecardsentitem->scheduled_date)) {
            foreach ($ecardsentitem->ecardsentrecipients as $recipient) {
                $blacklist_check = BlackList::where('email', '=', $recipient->email)->count();
                if ($blacklist_check < 1) {
                    Mail::to($recipient->email)->queue(new CardSendMail($recipient));

                    $recipient->sent_queued = 1;
                    $recipient->save();
                }
            }

            if ($ecardsentitem->pickup_noti == 1) {

                $mail_to = auth()->user()->email;

                Mail::to($mail_to)->queue(new PickupNotiMail($recipient));
            }
        }

        $message = "success";

        return response([
            'data' => [
                'code' => '000',
                'response' => new EcardsentItemResource(EcardsentItem::with('ecardsentrecipients')->where('id', $ecardsentitem->id)->first()),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EcardsentItemResource(EcardsentItem::with('ecardsentrecipients')->find($id));
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
        $ecardsentitem = EcardsentItem::find($id);
        if (!$ecardsentitem->draft) {
            return response()->json(['message' => 'Only dreafted cards can be edited'], 406);
        }

        $rules = [
            'ecard_id' => 'required|numeric',
            'greeting' => 'required',
            'message' => 'required',
            'timezone' => 'timezone',
        ];

        if (!$request->draft) {
            //$rules['scheduled_date'] = 'required';
            $rules['recipients'] = 'required|array';
        }

        if ($request->recipients) {
            $rules['recipients.*.name'] = 'required';
            $rules['recipients.*.email'] = 'required|email';
        }

        $request->validate($rules);

        $ecardsentitem->user_id = auth()->user()->id;
        $ecardsentitem->ecard_id = $request->ecard_id;
        $ecardsentitem->greeting = $request->greeting;
        $ecardsentitem->message = $request->message;
        $ecardsentitem->email_message = $request->email_message;
        $ecardsentitem->timezone = $request->timezone;

        if ($request->scheduled_date)
            $ecardsentitem->scheduled_date = date('Y-m-d H:i:s', strtotime($request->scheduled_date));

        if ($request->draft)
            $ecardsentitem->draft = 1;
        else
            $ecardsentitem->draft = 0;

        $ecardsentitem->save();

        $ecardsentitem->ecardsentrecipients()->delete();
        $ecardsentitem->ecardsentrecipients()->createMany($request->recipients);

        if ($ecardsentitem->draft == 0 && is_null($ecardsentitem->scheduled_date)) {
            foreach ($ecardsentitem->ecardsentrecipients as $recipient) {
                $blacklist_check = BlackList::where('email', '=', $recipient->email)->count();
                if ($blacklist_check < 1) {
                    Mail::to($recipient->email)
                        ->queue(new CardSendMail($recipient));

                    $recipient->sent_queued = 1;
                    $recipient->save();
                }
            }
        }

        $message = "success";

        return response([
            'data' => [
                'code' => '000',
                'response' => new EcardsentItemResource(EcardsentItem::with('ecardsentrecipients')->where('id', $id)->first()),
                'message' => $message
            ],
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ecardsentitem = EcardsentItem::find($id);

        if (!$ecardsentitem->draft) {
            return response()->json(['message' => 'Only dreafted cards can be deleted'], 406);
        }

        try {
            $ecardsentitem->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json($e->errorInfo[2], 500);
        }
        return response()->json(null, 204);
    }
}
