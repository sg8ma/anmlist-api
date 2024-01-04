<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserAnime;
use Illuminate\Http\Request;

class UserAnimeController extends Controller
{
    public function list(Request $request, $user_id)
    {
        $response['result'] = (new UserAnime())->list($user_id);
        return response()->json($response);
    }

    public function update(Request $request, $user_id, $anime_id)
    {    
        $response['result'] = (new UserAnime())->update($user_id, $request->input('season_id'), $anime_id, $request->input('day_of_week'), $request->input('start_time'));
        return response()->json($response);
    }

    public function delete(Request $request, $user_id, $anime_id)
    {
        $response['result'] = (new UserAnime())->delete($user_id, $request->input('season_id'), $anime_id);
        return response()->json($response);
    }
}
