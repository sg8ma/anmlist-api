<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SessionWrapper;
use Illuminate\Http\Request;

class UserSessionController extends Controller
{
    public function exists(Request $request, $key)
    {
        $response['key'] = $key;
        $response['login_status'] = ((new SessionWrapper())->ExistsId($key))? 1 : 0;
        return response()->json($response);
    }

    public function delete(Request $request, $key)
    {
        $user = (new User())->read($id);
        return response()->json($user);
    }

    public function read_data(Request $request, $key)
    {
        $user = (new User())->create($request->input('user_name'), $request->input('custom_user_id'));
        return response()->json($user);
    }

    public function put_data(Request $request, $key)
    {
        $user = (new User())->list($id, $request->input('user_name'), $request->input('custom_user_id'));
        return response()->json($user);
    }
}
