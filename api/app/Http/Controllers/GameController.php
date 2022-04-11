<?php

namespace App\Http\Controllers;

use App\Library\Common;
use App\Models\Game;
use App\Models\HardwareMaster;
use App\Models\PurposeMaster;
use App\Models\Recruitments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * ゲーム一覧取得
     */
    public function getGameList(Request $request)
    {
        // ゲーム取得
        $game_list = Game::with('hardware:hardware_id,hardware_name')
            ->get()
            ->toArray();
        if (empty($game_list)) {
            return Common::makeNotFoundResponse('game list not found');
        }
        // 階層を上げる
        $format_game_list = array_map(function ($game) {
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
        $game = Game::with('hardware:hardware_id,hardware_name')
            ->where('id', $game_id)
            ->first()
            ->toArray();
        if (empty($game)) {
            return Common::makeNotFoundResponse('game not found');
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
        // $purpose_list = PurposeMaster::all()->toArray();

        // フレンド募集一覧取得
        $recruitment_master = Recruitments::with('hardware:hardware_id,hardware_name')
            ->where('game_id', $request->game_id)
            ->orderBy('created_at', 'desc')
            ->active()
            ->get()
            ->toArray();
        \Log::debug($recruitment_master);

        $recruitment_list = [];
        if (!empty($recruitment_master)) {
            foreach ($recruitment_master as $index => $recruitment)
                $recruitment_list[] = [
                    'id'    => $recruitment['id'],
                    'game_id'    => $recruitment['game_id'],
                    'hardware_id'    => $recruitment['hardware_id'],
                    'hardware_name'    => (isset($recruitment['hardware']['hardware_name'])) ? $recruitment['hardware']['hardware_name'] : '' ,
                    'comment'    => $recruitment['comment'],
                    'ps_id'    => $recruitment['ps_id'],
                    'steam_id'    => $recruitment['steam_id'],
                    'origin_id'    => $recruitment['origin_id'],
                    'skype_id'    => $recruitment['skype_id'],
                    'discord_id'    => $recruitment['discord_id'],
                    'friend_code_id'    => $recruitment['friend_code_id'],
                    'created_at'    => $this->formatDate($recruitment['created_at']),
                ];
        }

        return Common::makeResponse([
            'game'      => $game,
            'hardwares'  => $hardwares,
            'recruitment_list' => $recruitment_list
        ]);
    }

    /**
     * フレンド募集
     */
    public function recruitment(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'game_id'           => 'required|integer',
            'hardware_id'       => 'required|integer',
            'comment'           => 'required|string',
            'ps_id'             => 'nullable|string',
            'steam_id'          => 'nullable|string',
            'origin_id'         => 'nullable|string',
            'skype_id'          => 'nullable|string',
            'discord_id'        => 'nullable|string',
            'friend_code_id'    => 'nullable|string',
        ]);
        // \Log::debug($request->all());
        if ($validation->fails()) {
            return Common::makeValidationErrorResponse($validation->errors());
        }

        try {
            DB::transaction(function ()  use ($request) {
                $recruitment = new Recruitments();
                $data = [
                    'game_id'           => $request->game_id,
                    'hardware_id'       => $request->hardware_id,
                    'comment'           => $request->comment,
                    'ps_id'             => $request->ps_id,
                    'steam_id'          => $request->steam_id,
                    'origin_id'         => $request->origin_id,
                    'skype_id'          => $request->skype_id,
                    'discord_id'        => $request->discord_id,
                    'friend_code_id'    => $request->friend_code_id,
                ];
                $recruitment->fill($data)->save();
            });
        } catch (\Exception $error) {
            return Common::makeNotFoundResponse($error);
        }

        return Common::makeResponse([
            'state'  => 'success'
        ]);
    }


    /**
     * 日付フォーマット 「Y/m/d」
     */
    public function formatDate(string $date): string
    {
        if (empty($date)) return '';
        $carbon = new Carbon($date);
        return $carbon->format('Y/m/d');
    }
}