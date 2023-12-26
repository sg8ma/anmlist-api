<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SessionWrapper;
use App\Models\UserSession;
use Illuminate\Http\Request;

class UserSessionController extends Controller
{
    public function exists(Request $request)
    {
        $response['login_status'] = ((new SessionWrapper())->ExistsId($request->input('session_key')))? 1 : 0;
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $response['is_deleted'] = (new UserSession())->delete($request->input('session_key'));
        return response()->json($response);
    }

    public function read_data(Request $request)
    {
        $response['data'] = (new SessionWrapper())->Get($request->input('session_key'), $request->input('key'));
        return response()->json($response);
    }

    public function put_data(Request $request)
    {
        $response['put_status'] = (new SessionWrapper())->Put($request->input('session_key'), $request->input('key'), $request->input('value'));
        return response()->json($response);
    }
}
