<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserFavorite
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
            $anime_list = DB::table('tbl_user_favorite as a')
                ->leftJoin('tbl_anime as b', 'a.anime_id', '=', 'b.anime_id')
                ->select(
                    'a.user_id',
                    'a.anime_id',
                    'a.added_at',
                    'b.title',
                    'b.title_furigana',
                    'b.season_id',
                    'b.image_file',
                )
                ->whereNotNull('a.added_at')
                ->orderBy('a.added_at', 'desc')
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

    public function add($user_id, $anime_id)
    {
        if(empty($user_id)) return null;
        if(empty($anime_id)) return null;
        DB::beginTransaction();
        try
        {
            $result = DB::table('tbl_user_favorite')
                ->upsert([
                    'user_id' => $user_id,
                    'anime_id' => $anime_id,
                    'added_at' => Carbon::now(),
                ],
                ['user_id', 'anime_id'],
                ['added_at']
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

    public function delete($user_id, $anime_id)
    {
        if(empty($user_id)) return null;
        if(empty($anime_id)) return null;
        DB::beginTransaction();
        try
        {
            $result = DB::table('tbl_user_favorite')
                ->where('user_id', '=', $user_id)
                ->where('anime_id', '=', $anime_id)
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