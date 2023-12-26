<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SessionWrapper;

class UserSession
{
    public function delete($session_key)
    {
        $result = 0;
        DB::beginTransaction();
        try
        {
            $result = DB::table('tbl_session as a')
                ->where('session_key', '=', $session_key)
                ->update([
                    'is_deleted' => 1
                ]);
            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error('exception: ' . $e->getMessage());
            DB::rollBack();
            return $result;
        }
        return $result;
    }
}