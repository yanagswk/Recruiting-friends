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
        if (!DB::table('game')->where('id', 1)->exists()) {
            DB::table('game')->insert([
                [
                    'game_name' => 'Apex Legends',
                    'game_image_url'    => 'https://www.kaikatsu.jp/info/images/2021/ApexLegends_A4POP.jpg',
                    'hardware_id'   => 3,
                    'is_ps' => true,
                    'is_origin'  => false,
                    'is_skype'  => false,
                    'is_discord' => false,
                    'is_steam' => false,
                    'is_friend_code' => false,
                ],
                [
                    'game_name' => 'Apex Legends',
                    'game_image_url'    => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIdTPBjBCUPKhxHLR26gt29RnVZ1bqY3AiuA&usqp=CAU',
                    'hardware_id'   => 4,
                    'is_ps' => false,
                    'is_origin'  => false,
                    'is_skype'  => false,
                    'is_discord' => false,
                    'is_steam' => false,
                    'is_friend_code' => true,
                ],
                // [
                //     'game_name' => 'Apex Legends',
                //     'game_image_url'    => 'https://makuring.com/game/wp-content/uploads/2022/01/apex-gamingpc-1024x576.jpg',
                //     'hardware_id'   => 5
                // ],
                [
                    'game_name' => 'Apex Legends',
                    'game_image_url'    => 'https://m.media-amazon.com/images/I/81xeaAYaHUL._AC_SL1500_.jpg',
                    'hardware_id'   => 6,
                    'is_ps' => false,
                    'is_origin'  => true,
                    'is_skype'  => true,
                    'is_discord' => true,
                    'is_steam' => false,
                    'is_friend_code' => false,
                ],
                [
                    'game_name' => 'VALORANT ヴァロラント',
                    'game_image_url'    => 'https://automaton-media.com/wp-content/uploads/2021/09/20210930-177446-header-696x391.jpg',
                    'hardware_id'   => 6,
                    'is_ps' => false,
                    'is_origin'  => false,
                    'is_skype'  => true,
                    'is_discord' => true,
                    'is_steam' => false,
                    'is_friend_code' => false,
                ],
            ]);
        }

        if (!DB::table('hardware_master')->where('hardware_id', 1)->exists()) {
            DB::table('hardware_master')->insert([
                ['hardware_name' => 'PS4'],
                ['hardware_name' => 'PS5'],
                ['hardware_name' => 'PS4/PS5'],
                ['hardware_name' => 'Swich'],
                ['hardware_name' => 'XboxOne'],
                ['hardware_name' => 'PC'],
            ]);
        }
        if (!DB::table('purpose_master')->where('purpose_id', 1)->exists()) {
            DB::table('purpose_master')->insert([
                ['purpose_name' => 'フレンドになろう！'],
                ['purpose_name' => '協力プレイがしたい！'],
                ['purpose_name' => '対戦プレイがしたい！'],
                ['purpose_name' => '練習がしたい！'],
                ['purpose_name' => 'その他'],
            ]);
        }
        // if (!DB::table('recruitment')->where('purpose_id', 1)->exists()) {
        //     DB::table('recruitment')->insert([
        //         [
        //             'game' => 'フレンドになろう！'
        //         ],
        //     ]);
        // }
    }
}
