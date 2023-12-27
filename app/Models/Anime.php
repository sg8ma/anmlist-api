<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Anime
{
    public function __construct()
    {
        return $this;
    }

    public function list($season_id = '2023spr')
    {
        $anime_list = null;
        DB::beginTransaction();
        try
        {
            $anime_list = DB::table('tbl_anime')
                ->select(
                    'anime_id',
                    'title',
                    'title_furigana',
                    'season_id',
                    'image_file',
                    'description',
                    'studio',
                    'fast_broadcast_date',
                    'url_web_broadcast',
                    'url_web',
                    'url_x',
                    'url_youtube',
                )
                ->orderBy('title_furigana', 'asc')
                ->orderBy('studio', 'asc')
                ->where('season_id', '=', $season_id)
                ->get();
            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error('exception: ' . $e->getMessage());
            DB::rollBack();
        }
        return $anime_list;
    }

    public function search_title()
    {

    }

    public function search_all()
    {

    }

    //検索
    // あいうえお順
    // タイトル検索
}