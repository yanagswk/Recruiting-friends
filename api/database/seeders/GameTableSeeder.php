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
        DB::table('game_list')->insert([
            [
                'game_name' => 'Apex Legends',
                'game_image_url'    => 'amazon.com/images/I/81Hz6w26goL._AC_SX425_.jpg',
                'hardware_id'   => 1
            ],
            [
                'game_name' => 'Apex Legends',
                'game_image_url'    => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIdTPBjBCUPKhxHLR26gt29RnVZ1bqY3AiuA&usqp=CAU',
                'hardware_id'   => 2
            ],
            [
                'game_name' => 'Apex Legends',
                'game_image_url'    => 'https://makuring.com/game/wp-content/uploads/2022/01/apex-gamingpc-1024x576.jpg',
                'hardware_id'   => 3
            ],
            [
                'game_name' => 'Apex Legends',
                'game_image_url'    => 'https://m.media-amazon.com/images/I/81xeaAYaHUL._AC_SL1500_.jpg',
                'hardware_id'   => 4
            ],
            [
                'game_name' => 'VALORANT ヴァロラント',
                'game_image_url'    => 'https://automaton-media.com/wp-content/uploads/2021/09/20210930-177446-header-696x391.jpg',
                'hardware_id'   => 3
            ],
        ]);

        DB::table('hardware_master')->insert([
            ['hardware_name' => 'PS4'],
            ['hardware_name' => 'PS5'],
            ['hardware_name' => 'PC'],
            ['hardware_name' => 'Swich'],
        ]);
    }
}