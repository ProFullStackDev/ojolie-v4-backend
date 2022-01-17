<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\FreeMemberActivateMail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function forgot_password(Request $request)
    {
        $input = $request->all();

        $rules = array(
            'email' => "required|email",
        );

        $validator = Validator::make($input, $rules);
        $user_check = User::where('email', '=', $request->email)->count();


        if($user_check < 1) {
            return response()->json(['message' => 'User does not exist.', 'email' => $request->email], 200);
        }

        elseif($user_check == 1) {
            $user = User::where('email', '=', $request->email)->first();
            if ($user->active == -1) {
                Mail::to($user->email)
                    ->queue(new FreeMemberActivateMail($user));
                return response()->json(['message' => 'Need To Verify Email Address', 'email' => $user->email], 200);
            } else {
                if ($validator->fails()) {
                    return response()->json(["code" => 400, "message" => $validator->errors()->first(), "data" => $request->only('email')]);
                } else {
                    $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                        $message->subject($this->getEmailSubject());
                    });
                    Password::RESET_LINK_SENT;
                    return response()->json(["code" => "000", "message" => trans($response), "data" => $request->only('email')]);
                }
            }
        }

    }
}
