<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function list(Request $request)
    {
        $response = (new Anime())->list();
        return response()->json($response);
    }

    // public function search(Request $request)
    // {
    //     $user = (new Anime())->search($request->input('user_name'), $request->input('custom_user_id'));
    //     return response()->json($user);
    // }

    // public function read(Request $request, $id)
    // {
    //     $user = (new Anime())->read($id);
    //     return response()->json($user);
    // }
}
