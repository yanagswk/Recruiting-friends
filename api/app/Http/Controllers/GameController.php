<?php

namespace App\Http\Controllers;

use App\Library\Common;
use App\Mail\ContactMail;
use App\Models\GameMaster;
use App\Models\HardwareMaster;
use App\Models\PurposeMaster;
use App\Models\HardwareFriendMaster;
use App\Models\Recruitments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * ゲーム一覧取得
     */
    public function getGameList(Request $request)
    {
        // ゲーム取得
        $game_master = GameMaster::select('id', 'game_name', 'url_name', 'game_image_url')
            ->with(['hardwareFriend' => function ($query) {
                $query->with(['hardware']);
            }])
            ->get()
            ->toArray();

        \Log::debug($game_master);

        if (empty($game_master)) {
            return Common::makeNotFoundResponse('game list not found');
        }

        $game_list = [];
        foreach ($game_master as $index => $game) {
            $hardware_list = [];
            foreach ($game['hardware_friend'] as $i => $v) {
                $hardware_list[$v['hardware']['hardware_id']] = $v['hardware']['hardware_name'];
            }
            $game_list[] = [
                'id'                => $game['id'],
                'game_name'         => $game['game_name'],
                'url_name'          => $game['url_name'],
                'game_image_url'    => $game['game_image_url'],
                'hardware_list'     => array_unique($hardware_list)
            ];
        }

        // $hardware_friend_master = HardwareFriendMaster::with(['hardware:hardware_id,hardware_name'])
        //     ->get()
        //     ->toArray();

        \Log::debug($game_list);

        // ハードウェア一覧取得
        $hardware_master = HardwareMaster::where('hardware_id', '<>', HardwareMaster::PS4PS5)
            ->get()
            ->pluck("hardware_name", "hardware_id")
            ->toArray();
        if (empty($hardware_master)) {
            $hardware_master = [];
        }

        return Common::makeResponse([
            'game_list' => $game_list,
            'hardware_list'   => $hardware_master
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
            'page'      => 'nullable|integer',
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
            // ->get()
            ->paginate(config('game.paginate'))   // TODO: 直す
            ->toArray();

        $recruitment_list = [];
        $page_data = [];
        if (!empty($recruitment_master)) {
            // TODO: data
            foreach ($recruitment_master['data'] as $index => $recruitment)
                $recruitment_list[] = [
                    'id'    => $recruitment['id'],
                    'game_id'    => $recruitment['game_id'],
                    'hardware_id'    => $recruitment['hardware_id'],
                    'hardware_name'    => (isset($recruitment['hardware']['hardware_name'])) ? $recruitment['hardware']['hardware_name'] : '',
                    'comment'    => $recruitment['comment'],
                    'ps_id'    => $recruitment['ps_id'],
                    'steam_id'    => $recruitment['steam_id'],
                    'origin_id'    => $recruitment['origin_id'],
                    'skype_id'    => $recruitment['skype_id'],
                    'discord_id'    => $recruitment['discord_id'],
                    'friend_code_id'    => $recruitment['friend_code_id'],
                    'created_at'    => $this->formatDate($recruitment['created_at']),
                ];
            $page_data = [
                'total' => $recruitment_master["total"],
                'per_page' => $recruitment_master["per_page"],
                'current_page' => $recruitment_master["current_page"],
                'last_page' => $recruitment_master["last_page"]
            ];
        }

        return Common::makeResponse([
            'game'      => $game,
            'hardwares'  => $hardwares,
            'recruitment_list' => $recruitment_list,
            'page_data' => $page_data
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
     * 追加してほしいゲームをメール送信
     */
    public function requestAddGameMail(Request $request)
    {
        $game_name = $request->input('game_name');
        $hardware_id_list = $request->input('hardware_id_list');
        $user_message = $request->input('user_message');

        $validation = Validator::make($request->all(), [
            'game_name'         => 'required|string',
            'hardware_id_list'  => 'nullable|array',
            'user_message'      => 'nullable|string',
        ]);
        if ($validation->fails()) {
            return Common::makeValidationErrorResponse($validation->errors());
        }

        $hardware = [];
        if (!empty($hardware_id_list)) {
            $hardware = HardwareMaster::whereIn("hardware_id", $hardware_id_list)
                ->pluck("hardware_name");
            if ($hardware->isEmpty()) {
                return Common::makeNotFoundResponse('hardware not found');
            }
        }
        $contact = [
            'game_name'  => $game_name,
            'hardware_name'  => ($hardware) ? implode("・", $hardware->toArray()) : "指定なし",
            'user_message'   => $user_message ?? ""
        ];

        Mail::to("yanagimassu@gmail.com")->send(new ContactMail($contact));

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
