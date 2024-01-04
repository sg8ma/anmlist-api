<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserFavorite;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function list(Request $request, $user_id)
    {
        $response['result'] = (new UserFavorite())->list($user_id);
        return response()->json($response);
    }

    public function add(Request $request, $user_id, $anime_id)
    {
        $response['result'] = (new UserFavorite())->add($user_id, $anime_id);
        return response()->json($response);
    }

    public function delete(Request $request, $user_id, $anime_id)
    {
        $response['result'] = (new UserFavorite())->delete($user_id, $anime_id);
        return response()->json($response);
    }
}
