<?php

use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/game_list', [GameController::class, 'getGameList']);
Route::get('/game', [GameController::class, 'getGame']);

Route::post('/recruitment', [GameController::class, 'recruitment']);

Route::post('/request_add_game_mail', [GameController::class, 'requestAddGameMail']);

Route::post('/inquiry_mail', [GameController::class, 'inquiryMail']);