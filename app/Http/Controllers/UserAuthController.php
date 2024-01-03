<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestSend;

class UserAuthController extends Controller
{
    public function create(Request $request, $type)
    {
        $response['auth_status'] = 0;
        if($type == 'mail')
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

    public function login(Request $request, $type)
    {
        if($type == 'mail')
        {
            $response = (new UserAuth())->login_mail($request->input('mail'), $request->input('password'));
        }
        return response()->json($response);
    }

    public function test_mail(Request $request)
    {
        Mail::to($request->user())->send(new TestSend());
        return response()->json($response);
    }
}
