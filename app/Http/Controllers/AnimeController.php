<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function search(Request $request)
    {
        $response = [];
        $response['search']['season_id'] = $request->input('season_id');
        $response['search']['keyword'] = $request->input('keyword');
        $response['search']['sort_by'] = $request->input('sort_by');
        $response['search']['sort_order'] = $request->input('sort_order');
        $response['result'] = (new Anime())->list(
            season_id: $request->input('season_id'),
            keyword: $request->input('keyword'),
            sort_by: $request->input('sort_by'),
            sort_order: $request->input('sort_order')
        );
        return response()->json($response);
    }

    public function detail(Request $request, $id)
    {
        $response = [];
        $response['anime'] = (new Anime())->detail($id);
        $response['anime']['favorite'] = (new Anime())->detail_favorite($id);
        $response['anime']['broadcast'] = (new Anime())->detail_broadcast($id);
        return response()->json($response);
    }
}
