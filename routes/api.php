<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\AnimeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ユーザー新規登録画面
Route::post('/user', [UserController::class, 'create']);
Route::post('/user/auth/{type}', [UserAuthController::class, 'create']);
Route::get('/user/auth/mail/otp', [UserAuthController::class, 'check_otp']);
Route::post('/user/auth/mail/test', [UserAuthController::class, 'test_mail']);

// ユーザー認証画面
Route::post('/user/login/{type}', [UserAuthController::class, 'login']);       //ログイン
Route::get('/user/session', [UserSessionController::class, 'exists']); //ログインステータス確認
Route::delete('/user/session', [UserSessionController::class, 'delete']); //ログアウト

// ユーザー情報画面
Route::get('/user', [UserController::class, 'list']);
Route::get('/user/{id}', [UserController::class, 'read']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'delete']);
Route::delete('/user/auth/{type}', [UserAuthController::class, 'delete']);

// アニメ情報画面
Route::post('/anime/search', [AnimeController::class, 'search']);
Route::get('/anime/{id}', [AnimeController::class, 'detail']);

// お気に入り
Route::get('/user/{user_id}/favorite', [UserFavoriteController::class, 'list']); // お気に入り一覧
Route::put('/user/{user_id}/favorite/{anime_id}', [UserFavoriteController::class, 'add']);
Route::delete('/user/{user_id}/favorite/{anime_id}', [UserFavoriteController::class, 'delete']); 

// My番組表
Route::get('/user/{user_id}/anime', [UserAnimeController::class, 'list']); 
Route::post('/user/{user_id}/anime/{anime_id}', [UserAnimeController::class, 'update']); 
Route::delete('/user/{id}/anime/{anime_id}', [UserAnimeController::class, 'delete']); 

// 他
Route::get('/user/session/data', [UserSessionController::class, 'read_data']);
Route::put('/user/session/data', [UserSessionController::class, 'put_data']);


