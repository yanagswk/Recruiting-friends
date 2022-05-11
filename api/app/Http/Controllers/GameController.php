<?php

namespace App\Http\Controllers;

use App\Library\Common;
use App\Mail\ContactMail;
use App\Models\FriendMaster;
use App\Models\GameMaster;
use App\Models\HardwareMaster;
use App\Models\PurposeMaster;
use App\Models\HardwareFriendMaster;
use App\Models\Recruitments;
use App\Models\UserFriendName;
use App\Models\UserRecruitment;
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

        // \Log::debug($game_master);

        if (empty($game_master)) {
            return Common::makeNotFoundResponse('game list not found');
        }

        $game_list = [];
        foreach ($game_master as $index => $game) {
            $hardware_list = [];
            foreach ($game['hardware_friend'] as $i => $v) {
                $hardware_list[$v['hardware']['id']] = $v['hardware']['hardware_name'];
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

        // \Log::debug($game_list);

        // ハードウェア一覧取得
        $hardware_master = HardwareMaster::where('id', '<>', HardwareMaster::PS4PS5)
            ->get()
            ->pluck("hardware_name", "id")
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
            'game_id'       => 'required|integer',
            'page'          => 'nullable|integer',
            'hardware_id'   => 'nullable|integer',
        ]);
        if ($validation->fails()) {
            return Common::makeValidationErrorResponse($validation->errors());
        }

        // ゲーム取得
        $game_master = GameMaster::where('id', $game_id)
            ->with(['hardwareFriend' => function ($query) {
                $query->with(['hardware', 'friend']);
            }])
            ->first();

        if (empty($game_master)) {
            return Common::makeNotFoundResponse('game not found');
        }

        $game_info = [
            'id'                => $game_master->id,
            'game_name'         => $game_master->game_name,
            'url_name'          => $game_master->url_name,
            'game_image_url'    => $game_master->game_image_url,
        ];

        // ハードウェアが持つフレンドidをグループ分けする
        foreach ($game_master->hardwareFriend as $index => $game) {
            $hardware_id = $game->hardware()->pluck('id')->first();
            $friend_id_list = $game->friend()->pluck('id')->first();
            $game_list[$hardware_id][] = $friend_id_list;
        }

        // ハードウェア一覧取得 // TODO: 処理被りあり。モデルクラスに持っていく
        $hardware_master = HardwareMaster::where('id', '<>', HardwareMaster::PS4PS5)
            ->get()
            ->pluck("hardware_name", "id")
            ->toArray();
        if (empty($hardware_master)) {
            $hardware_master = [];
        }

        // フレンドid一覧取得
        $friend_master = FriendMaster::pluck("friend_id_name", "id")
            ->toArray();
        if (empty($friend_master)) {
            $friend_master = [];
        }

        $min_hardware_friend = HardwareFriendMaster::where('game_id', $game_id)->min('hardware_id');

        // フレンド募集一覧取得
        $hardware_id = $request->hardware_id ?? $min_hardware_friend ?? 0;
        $recruitment_master = userRecruitment::where([
                ['game_id', $game_id],
                ['hardware_id', $hardware_id]
            ])
            ->with(['friendName' => function ($query) {
                $query->with(['friend:id,friend_id_name']);
            }])
            ->with(['hardware:id,hardware_name'])
            ->orderBy('created_at', 'desc')
            // ->paginate(config('game.paginate'));
            ->get();

        $recruitment_list = [];
        foreach ($recruitment_master as $recruitment) {
            $friend_name_list = [];
            foreach ($recruitment->friendName as $friend) {
                $friend_name_list[] = [
                    'hardware_friend_id'    => $friend->hardware_friend_id,
                    'friend_id_name'        => $friend->friend->friend_id_name,
                    'friend_name'           => $friend->friend_name
                ];
            }
            $recruitment_list[] = [
                'id'                => $recruitment->id,
                'game_id'           => $recruitment->game_id,
                'hardware_id'       => $recruitment->hardware_id,
                'hardware_name'     => $recruitment->hardware->hardware_name,
                'comment'           => $recruitment->comment,
                'created_at'        => $this->formatDate($recruitment->created_at),
                'friend_name_list'  => $friend_name_list
            ]; 
        }

        // $page_list = $recruitment_master->toArray();
        // $page_data = [
        //     'total' => $page_list["total"],
        //     'per_page' => $page_list["per_page"],
        //     'current_page' => $page_list["current_page"],
        //     'last_page' => $page_list["last_page"]
        // ];

        return Common::makeResponse([
            'game'              => $game_info,
            'hardware_list'     => $hardware_master,
            'friend_list'       => $friend_master,
            'friend_id_list'    => $game_list,
            'recruitment_list'  => $recruitment_list,
            // 'page_data'         => $page_data
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
        if ($validation->fails()) {
            return Common::makeValidationErrorResponse($validation->errors());
        }

        try {
            DB::transaction(function ()  use ($request) {
                $friend_list = $request->only('ps_id', 'steam_id', 'friend_code_id', 'origin_id', 'skype_id', 'discord_id');

                $user_recruitment = new UserRecruitment();
                $user_recruitment->fill([
                    'game_id'       => $request->game_id,
                    'hardware_id'   => (int)$request->hardware_id,
                    'comment'       => $request->comment
                ])->save();

                $last_data = UserRecruitment::orderBy('created_at', 'desc')->first();
                foreach ($friend_list as $index => $friend) {
                    if (is_null($friend)) {
                        continue;
                    }
                    $friend_id = FriendMaster::where('friend_id_name', $index)->value('id');
                    $data = [
                        'recruitment_id'        => $last_data->id,
                        'hardware_id'           => (int)$request->hardware_id,
                        'hardware_friend_id'    => $friend_id,
                        'friend_name'           => $friend_list[$index]
                    ];
                    UserFriendName::create($data);
                }
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
            $hardware = HardwareMaster::whereIn("id", $hardware_id_list)
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