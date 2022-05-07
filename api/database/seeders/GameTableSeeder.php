<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('game_master')->where('id', 1)->exists()) {
            DB::table('game_master')->insert([
                [
                    'game_name' => 'Apex Legends',
                    'url_name'   => 'apex_legend',
                    'game_image_url'    => 'https://www.kaikatsu.jp/info/images/2021/ApexLegends_A4POP.jpg',
                ],
                [
                    'game_name' => 'VALORANT ヴァロラント',
                    'url_name'   => 'valorant',
                    'game_image_url'    => 'https://automaton-media.com/wp-content/uploads/2021/09/20210930-177446-header-696x391.jpg',
                ],
            ]);
        }

        if (!DB::table('hardware_friend_master')->where('id', 1)->exists()) {
            DB::table('hardware_friend_master')->insert([
                [
                    'game_id' => 1,
                    'hardware_id' => 1,
                    'friend_id'   => 1,
                ],
                [
                    'game_id' => 1,
                    'hardware_id' => 2,
                    'friend_id'   => 1,
                ],
                [
                    'game_id' => 1,
                    'hardware_id' => 6,
                    'friend_id'   => 2,
                ],
                [
                    'game_id' => 1,
                    'hardware_id' => 6,
                    'friend_id'   => 3,
                ],
                [
                    'game_id' => 1,
                    'hardware_id' => 6,
                    'friend_id'   => 4,
                ],
                [
                    'game_id' => 2,
                    'hardware_id' => 6,
                    'friend_id'   => 3,
                ],
                [
                    'game_id' => 2,
                    'hardware_id' => 6,
                    'friend_id'   => 4,
                ],
            ]);
        }

        if (!DB::table('game_friend')->where('id', 1)->exists()) {
            DB::table('game_friend')->insert([
                [
                    'game_id' => 1,
                    'friend_id'   => 1,
                ],
                [
                    'game_id' => 1,
                    'friend_id'   => 1,
                ],
                [
                    'game_id' => 1,
                    'friend_id'   => 2,
                ],
                [
                    'game_id' => 1,
                    'friend_id'   => 3,
                ],
                [
                    'game_id' => 1,
                    'friend_id'   => 4,
                ],
                [
                    'game_id' => 2,
                    'friend_id'   => 3,
                ],
                [
                    'game_id' => 2,
                    'friend_id'   => 4,
                ],
            ]);
        }
        if (!DB::table('game_hardware')->where('id', 1)->exists()) {
            DB::table('game_hardware')->insert([
                [
                    'game_id' => 1,
                    'hardware_id'   => 1,
                ],
                [
                    'game_id' => 1,
                    'hardware_id'   => 2,
                ],
                [
                    'game_id' => 1,
                    'hardware_id'   => 4,
                ],
                [
                    'game_id' => 1,
                    'hardware_id'   => 6,
                ],
                [
                    'game_id' => 2,
                    'hardware_id'   => 6,
                ],
            ]);
        }

        if (!DB::table('hardware_master')->where('id', 1)->exists()) {
            DB::table('hardware_master')->insert([
                ['hardware_name' => 'PS4'],
                ['hardware_name' => 'PS5'],
                ['hardware_name' => 'PS4/PS5'],
                ['hardware_name' => 'Swich'],
                ['hardware_name' => 'XboxOne'],
                ['hardware_name' => 'PC'],
            ]);
        }
        if (!DB::table('friend_master')->where('id', 1)->exists()) {
            DB::table('friend_master')->insert([
                ['friend_id_name' => 'PS_ID'],
                ['friend_id_name' => 'Origin_ID'],
                ['friend_id_name' => 'Skype_ID'],
                ['friend_id_name' => 'Discord_ID'],
                ['friend_id_name' => 'Steam_ID'],
                ['friend_id_name' => 'Friend_Code'],
            ]);
        }
        // if (!DB::table('purpose_master')->where('purpose_id', 1)->exists()) {
        //     DB::table('purpose_master')->insert([
        //         ['purpose_name' => 'フレンドになろう！'],
        //         ['purpose_name' => '協力プレイがしたい！'],
        //         ['purpose_name' => '対戦プレイがしたい！'],
        //         ['purpose_name' => '練習がしたい！'],
        //         ['purpose_name' => 'その他'],
        //     ]);
        // }
        // if (!DB::table('recruitment')->where('purpose_id', 1)->exists()) {
        //     DB::table('recruitment')->insert([
        //         [
        //             'game' => 'フレンドになろう！'
        //         ],
        //     ]);
        // }
    }
}
