<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAuth;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function create(Request $request)
    {
        $response['auth_status'] = 0;
        if($request->path() == 'user/auth/mail')
        {
            $user = (new User())->create($request->input('username'));
            if($user != null)
            {
                $response['auth_status'] = (new UserAuth())->register_mail($user->user_id, $request->input('mail'), $request->input('password'));
            }
        }
        return response()->json($response);
    }

    public function check_otp(Request $request)
    {
        $response = (new UserAuth())->check_mail_token($request->input('token'), $request->input('otp'));
        return response()->json($response);
    }
}