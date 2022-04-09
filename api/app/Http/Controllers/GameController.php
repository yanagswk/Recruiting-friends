<?php

namespace App\Http\Controllers;

use App\Library\Common;
use App\Models\GameList;
use App\Models\HardwareMaster;
use App\Models\PurposeMaster;
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

        $hardwares = [];
        if ($game['hardware_id'] === HardwareMaster::PS4PS5) {
            $hardwares[] = [
                'hardware_id' => HardwareMaster::PS4,
                'hardware_name' => 'PS4'
            ];
            $hardwares[] = [
                'hardware_id' => HardwareMaster::PS5,
                'hardware_name' => 'PS5'
            ];
        } else {
            $hardwares[] = [
                'hardware_id' => $game['hardware_id'],
                'hardware_name' => $game['hardware_name']
            ];
        }

        // 目的一覧取得
        $purpose_list = PurposeMaster::all()->toArray();

        return Common::makeResponse([
            'game'      => $game,
            'hardwares'  => $hardwares,
            'purpose_list' => $purpose_list ?? []
        ]);
    }
}