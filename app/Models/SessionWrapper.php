<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SessionWrapper
{
    public function __construct()
    {
        return $this;
    }

    public function RegenerateId()
    {
        while(true)
        {
            Session::regenerate();
            $sessionData = DB::table('tbl_session')
                ->select('session_key')
                ->where('session_key', Session::getId())
                ->where('is_deleted', '=', 0)
                ->first();
            if($sessionData->session_key != Session::getId()) break;
        }
        DB::beginTransaction();
        try
        {
            $sessionKey = Session::getId();
            $tmpMax = DB::table('tbl_session')
                ->max('session_id');
            $sessionId = $tmpMax + 1;
            DB::table('tbl_session')
                ->insert([
                    'session_id' => $sessionId, 
                    'session_key' => $sessionKey, 
                    'ip_address' => \Request::ip(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]); 
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            Log::error('exception: ' . $e->getMessage());
        }
        return $sessionKey;
    }

    private function ReadId(string $sessionKey)
    {
        DB::beginTransaction();
        try
        {
            $sessionData = DB::table('tbl_session')
                ->select('session_id')
                ->where('session_key', '=', $sessionKey)
                ->where('is_deleted', '=', 0)
                ->first();
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            Log::error('exception: ' . $e->getMessage());
            return 0;
        }      
        if(empty($sessionData->session_id)) return 0;
        return intval($sessionData->session_id);
    }

    public function ExistsId(string $sessionKey)
    {
        $sessionId = $this->ReadId($sessionKey);
        if($sessionId > 0)
        {
            return true;
        }
        return false;
    }

    public function RemoveId(string $sessionKey)
    {
        $sessionId = $this->ReadId($sessionKey);
        if($sessionId > 0)
        {
            DB::beginTransaction();
            try
            {
                DB::table('tbl_session')
                    ->where('session_id', '=', intval($sessionId))
                    ->update([
                        'updated_at' => Carbon::now(),
                        'is_deleted' => 1,
                    ]); 
                DB::commit();
            }
            catch (QueryException $e)
            {
                DB::rollback();
                Log::error('exception: ' . $e->getMessage());
                return false;
            }
            return true;
        }
        return true;
    }

    public function Put(string $sessionKey, string $key, $value)
    {
        $sessionId = $this->ReadId($sessionKey);
        if($sessionId > 0)
        {
            DB::beginTransaction();
            try
            {
                $sessionData = DB::table('tbl_session')
                    ->select('payload')
                    ->where('session_id', '=', intval($sessionId))
                    ->first(); 
                DB::commit();
            }
            catch (QueryException $e)
            {
                DB::rollback();
                Log::error('exception: ' . $e->getMessage());
                return false;
            }
            $payload = unserialize($sessionData->payload);
            $payload[$key] = $value;
            DB::beginTransaction();
            try
            {
                DB::table('tbl_session')
                    ->where('session_id', '=', intval($sessionId))
                    ->update([
                        'payload' => serialize($payload),
                        'updated_at' => Carbon::now(),
                    ]); 
                DB::commit();
            }
            catch (QueryException $e)
            {
                DB::rollback();
                Log::error('exception: ' . $e->getMessage());
                return false;
            }
            return true;
        }
        return false;
    }

    public function Get(string $sessionKey, string $key)
    {
        $sessionId = $this->ReadId($sessionKey);
        if($sessionId > 0)
        {
            DB::beginTransaction();
            try
            {
                $sessionData = DB::table('tbl_session')
                    ->select('payload')
                    ->where('session_id', '=', intval($sessionId))
                    ->first(); 
                DB::commit();
            }
            catch (QueryException $e)
            {
                DB::rollback();
                Log::error('exception: ' . $e->getMessage());
                return null;
            }
            $payload = unserialize($sessionData->payload);
            if(array_key_exists($key, $payload))
            {
                return $payload[$key];
            }
        }
        return null;
    }
}