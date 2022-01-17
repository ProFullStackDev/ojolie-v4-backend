<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;

class AccountVerifyController extends Controller
{
    public function active_user($id)
    {

        $user_id = decrypt($id);

        $user = User::find($user_id);

        $user->active = 1;

        $user->save();

        return redirect('https://staging-ojolie-frontend-pfylq.ondigitalocean.app/');
    }
}
