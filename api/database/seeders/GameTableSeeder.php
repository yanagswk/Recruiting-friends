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
                'hardware_id'   => 1
            ],
            [
                'game_name' => 'Apex Legends',
                'hardware_id'   => 2
            ],
            [
                'game_name' => 'Apex Legends',
                'hardware_id'   => 3
            ],
            [
                'game_name' => 'Apex Legends',
                'hardware_id'   => 4
            ],
            [
                'game_name' => 'VALORANT ヴァロラント',
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