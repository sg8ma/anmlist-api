<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserAnime
{
    public function __construct()
    {
        return $this;
    }

    public function list($user_id)
    {
        if(empty($user_id)) return null;
        DB::beginTransaction();
        try
        {
            $anime_list = DB::table('tbl_user_anime as a')
                ->leftJoin('tbl_anime as b', 'a.anime_id', '=', 'b.anime_id')
                ->select(
                    'a.user_id',
                    'a.season_id',
                    'a.anime_id',
                    'a.day_of_week',
                    'a.start_time',
                    'b.title',
                    'b.title_furigana',
                    'b.image_file',
                    'b.description',
                    'b.url_web',
                )
                ->where('a.user_id', '=', $user_id)
                ->orderBy('a.day_of_week', 'desc')
                ->get();
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            Log::error('exception: ' . $e->getMessage());
            return null;
        }   
        return $anime_list->toArray();
    }

    public function update($user_id, $season_id, $anime_id, $day_of_week, $start_time)
    {
        if(empty($user_id)) return null;
        if(empty($anime_id)) return null;
        if(empty($season_id)) return null;
        if(empty($day_of_week)) return null;
        if(empty($start_time)) return null;
        DB::beginTransaction();
        try
        {
            $result = DB::table('tbl_user_anime')
                ->upsert([
                    'user_id' => $user_id,
                    'season_id' => $season_id,
                    'anime_id' => $anime_id,
                    'day_of_week' => $day_of_week,
                    'start_time' => $start_time,
                    'updated_at' => Carbon::now(),
                ],
                ['user_id', 'season_id', 'anime_id'],
                ['day_of_week', 'start_time', 'updated_at']
                );
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            Log::error('exception: ' . $e->getMessage());
            return null;
        }   
        if($result > 0) return 1;
        return null;
    }

    public function delete($user_id, $season_id, $anime_id)
    {
        if(empty($user_id)) return null;
        if(empty($anime_id)) return null;
        if(empty($season_id)) return null;
        DB::beginTransaction();
        try
        {
            $result = DB::table('tbl_user_anime')
                ->where('user_id', '=', $user_id)
                ->where('anime_id', '=', $anime_id)
                ->where('season_id', '=', $season_id)
                ->delete();
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            Log::error('exception: ' . $e->getMessage());
            return null;
        }   
        if($result > 0) return 1;
        return null;
    }
}