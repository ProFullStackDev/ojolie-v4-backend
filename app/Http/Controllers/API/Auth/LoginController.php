<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\FreeMemberActivateMail;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = ['email' => 'required|exists:users', 'password' => 'required'];
        $request->validate($rules);

        $credentials = $request->only('email', 'password');

        if (Auth::once($credentials)) {
            $user = Auth::user();
            if($user->active == -1) {

                Mail::to($user->email)
                ->queue(new FreeMemberActivateMail($user));
                return response()->json(['code' => 422, 'message' => 'Need To Verify Email Address', 'email' => $user->email], 422);

            } else {

                $token = $user->createToken('token-name')->plainTextToken;
                $message = 'success';
                return response()->json(['code' => '000', 'api_token' => $token, 'message' => $message]);

            }

        } else {
            return response()->json(['message' => 'Invalid credentials!'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(null, 204);
    }
}
