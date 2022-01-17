<?php

namespace App\Http\Controllers\API\Mailing;

use App\Http\Controllers\Controller;
use App\Mailing;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\MailingResource;
use App\Http\Requests\MailingRequest;

class MailingController extends Controller
{
    public function index()
    {

        $mailing_lists = Mailing::all();

        return MailingResource::collection($mailing_lists);
    }

    public function store(MailingRequest $request)
    {
        $mailing = new Mailing;

        $mailing->email = $request->email;

        $mailing->save();

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new MailingResource($mailing),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return new MailingResource(Mailing::find($id));
    }
}
