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

    public function detail($anime_id)
    {
        if(empty($anime_id)) return null;
        DB::beginTransaction();
        try
        {
            $anime_data = DB::table('tbl_anime as a')
                ->select(
                    'a.anime_id',
                    'a.title',
                    'a.title_furigana',
                    'a.season_id',
                    'a.image_file',
                    'a.description',
                    'a.studio',
                    'a.fast_broadcast_date',
                    'a.url_web_broadcast',
                    'a.url_web',
                    'a.url_x',
                    'a.url_youtube',
                )
                ->where('a.anime_id', '=', $anime_id)
                ->first();
        }
        catch(\Exception $e)
        {
            Log::error('exception: ' . $e->getMessage());
            DB::rollBack();
            return null;
        }
        return $anime_data->toArray();
    }

    public function detail_broadcast($anime_id)
    {
        if(empty($anime_id)) return null;
        DB::beginTransaction();
        try
        {
            $anime_data = DB::table('tbl_anime as a')
                ->leftJoin('tbl_anime_broadcast as b', 'a.anime_id', '=', 'b.anime_id')
                ->leftJoin('tbl_channel as c', 'a.channel_id', '=', 'c.channel_id')
                ->select(
                    'a.anime_id',
                    'b.channel_id',
                    'c.channel_name',
                    'b.broadcast_day',
                    'b.broadcast_time',
                )
                ->where('a.anime_id', '=', $anime_id)
                ->get();
        }
        catch(\Exception $e)
        {
            Log::error('exception: ' . $e->getMessage());
            DB::rollBack();
            return null;
        }
        return $anime_data->toArray();
    }

    public function detail_favorite($anime_id)
    {
        if(empty($anime_id)) return null;
        DB::beginTransaction();
        try
        {
            $anime_data = DB::table('tbl_anime as a')
                ->leftJoin('tbl_user_favorite as b', 'a.anime_id', '=', 'b.anime_id')
                ->selectRaw('count(a.anime_id) as favorite_count')
                ->groupBy('a.anime_id')
                ->first();
        }
        catch(\Exception $e)
        {
            Log::error('exception: ' . $e->getMessage());
            DB::rollBack();
            return null;
        }
        return $anime_data->favorite_count;
    }

    public function search($season_id = '', $keyword = '', $sort_by = '', $sort_order = '')
    {
        $sort_order = match($sort_order)
        {
            'asc' => 'asc',
            'desc' => 'desc',
            default => 'asc',
        };
        $sort_by = match($sort_by)
        {
            'title' => 'title',
            'studio' => 'studio',
            'favorite' => 'favorite',
            default => '',
        };
        $anime_list = null;
        DB::beginTransaction();
        try
        {
            $anime_list = DB::table('tbl_anime as a')
                ->leftJoin('tbl_user_favorite as b', 'a.anime_id', '=', 'b.anime_id')
                ->select(
                    'a.anime_id',
                    'a.title',
                    'a.title_furigana',
                    'a.season_id',
                    'a.image_file',
                    'a.description',
                    'a.studio',
                    'a.fast_broadcast_date',
                    'a.url_web_broadcast',
                    'a.url_web',
                    'a.url_x',
                    'a.url_youtube',
                )
                ->selectRaw('count(a.anime_id) as favorite_count')
                ->groupBy('a.anime_id')
                ->when(!empty($keyword), function($query) use ($keyword) {
                    return $query->where('a.title', 'like', '%' . $keyword . '%');
                })
                ->when(!empty($season_id), function($query) use ($season_id) {
                    return $query->where('a.season_id', '=', $season_id);
                })
                ->when(!empty($sort_by), function($query) use ($sort_by, $sort_order) {
                    switch($sort_by)
                    {
                        case 'title':
                            return $query->orderBy('a.title_furigana', $sort_order);
                        case 'studio':
                            return $query->orderBy('a.studio', $sort_order);
                        case 'favorite':
                            return $query->orderByRaw('count(a.anime_id) ' . $sort_order);
                    }
                })
                ->get();
            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error('exception: ' . $e->getMessage());
            DB::rollBack();
        }
        if(empty($anime_list))
        {
            return null;
        }
        return $anime_list->toArray();
    }
}