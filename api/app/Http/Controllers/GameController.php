<?php

namespace App\Http\Controllers;

use App\Models\GameList;
use App\Models\HardwareMaster;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * ゲーム一覧取得
     */
    public function getGameList(Request $request)
    {
        $game_list = GameList::with('hardware:hardware_id,hardware_name')->get()->toArray();
        // 階層を上げる
        $format_game_list = array_map(function($game) {
            if (!empty($game['hardware'])) {
                $game = array_merge($game, $game['hardware']);
                unset($game['hardware']);
                return $game;
            }
        }, $game_list);

        return [
            'game_list' => $format_game_list,
        ];
    }
}