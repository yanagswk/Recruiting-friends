<?php

namespace App\Http\Controllers;

use App\Library\Common;
use App\Models\GameList;
use App\Models\HardwareMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * ゲーム一覧取得
     */
    public function getGameList(Request $request)
    {   
        // ゲーム取得
        $game_list = GameList::with('hardware:hardware_id,hardware_name')
                    ->get()
                    ->toArray();
        if (empty($game_list)) {
            return Common::makeNotFoundResponse();
        }
        // 階層を上げる
        $format_game_list = array_map(function($game) {
            if (!empty($game['hardware'])) {
                $game = array_merge($game, $game['hardware']);
                unset($game['hardware']);
                return $game;
            }
        }, $game_list);

        return Common::makeResponse([
            'game_list' => $format_game_list
        ]);
    }

    /**
     * ゲーム取得
     */
    public function getGame(Request $request)
    {
        $game_id = $request->input('game_id');
        $validation = Validator::make($request->all(), [
            'game_id'   => 'required|integer',
        ]);
        if ($validation->fails()) {
            return Common::makeValidationErrorResponse($validation->errors());
        }

        // 指定されたゲーム取得
        $game = GameList::with('hardware:hardware_id,hardware_name')
                ->where('id', $game_id)
                ->first()
                ->toArray();
        if (empty($game)) {
            return Common::makeNotFoundResponse();
        }

        // 階層を上げる
        if (!empty($game['hardware'])) {
            $game = array_merge($game, $game['hardware']);
            unset($game['hardware']);
        }

        return Common::makeResponse([
            'game' => $game
        ]);
    }
}