<?php

namespace App\Http\Controllers\API\Mailing;

use App\Http\Controllers\Controller;
use App\NewsletterSubscription;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\NewsletterSubscriptionResource;
use App\Http\Requests\NewsletterSubscriptionRequest;

class NewsletterSubscriptionController extends Controller
{
    public function index()
    {

        $mailing_lists = NewsletterSubscription::all();

        return NewsletterSubscriptionResource::collection($mailing_lists);
    }

    public function store(NewsletterSubscriptionRequest $request)
    {
        $mailing = new NewsletterSubscription;

        $mailing->email = $request->email;

        $mailing->save();

        if ($mailing->email) {

            $mail_to = $mailing->email;

            Mail::to($mail_to)->queue(new \App\Mail\NewsletterConfirmationMail($mailing));

        }

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new NewsletterSubscriptionResource($mailing),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return new NewsletterSubscriptionResource(NewsletterSubscription::find($id));
    }

    public function destroy($id)
    {
        $id_decrypt = decrypt($id);

        NewsletterSubscription::whereId($id_decrypt)->delete();

        return redirect('https://staging-ojolie-frontend-pfylq.ondigitalocean.app/unsubscribe-message');

    }
}
