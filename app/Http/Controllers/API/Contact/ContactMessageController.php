<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Controllers\Controller;
use App\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ContactMessageResource;
use App\Http\Requests\ContactMessageRequest;

class ContactMessageController extends Controller
{
    public function index()
    {

        $contact_messages = ContactMessage::all();

        return ContactMessageResource::collection($contact_messages);
    }

    public function store(ContactMessageRequest $request)
    {
        $contact_message = new ContactMessage;

        $contact_message->name = $request->name;

        $contact_message->email = $request->email;

        $contact_message->message = $request->message;

        $contact_message->save();

        if ($contact_message->email) {

            $mail_to = $contact_message->email;

            $query = [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ];

            Mail::to('support@ojolie.com')->send(new \App\Mail\ContactusMail($query));

            Mail::to('sto123p@gmail.com')->send(new \App\Mail\ContactusMail($query));

            Mail::to($mail_to)->send(new \App\Mail\ContactConfirmationMail($contact_message));

        }

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new ContactMessageResource($contact_message),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return new ContactMessageResource(ContactMessage::find($id));
    }
}
