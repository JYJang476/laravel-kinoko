<?php

use Illuminate\Database\Seeder;

class ProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        // 표고버섯 데이터 추가
//        DB::Table('programs')->insert([
//            'prg_userid' => random_int(1, 10),
//            'prg_machineid' => random_int(1, 10),
//            'prg_dateid' => random_int(1, 10),
//            'prg_name' => str_random(10),
//            'prg_type' => "shiitake",
//            'prg_water' => random_int(1, 3),
//            'prg_sunshine' => random_int(30, 200),
//            'prg_count' => random_int(0, 5),
//            'prg_compostname' => str_random('10'),
//            'prg_period' => random_int(5, 7)
//        ]);
//
//        // 백화고 데이터 추가
//        DB::Table('programs')->insert([
//            'prg_userid' => random_int(1, 10),
//            'prg_machineid' => random_int(1, 10),
//            'prg_dateid' => random_int(1, 10),
//            'prg_name' => str_random(10),
//            'prg_type' => "whiteFlower",
//            'prg_water' => random_int(1, 3),
//            'prg_sunshine' => random_int(30, 200),
//            'prg_count' => random_int(0, 5),
//            'prg_compostname' => str_random('10'),
//            'prg_period' => random_int(5, 7)
//        ]);

        // 커스텀 데이터 추가
        for($i = 0; $i < 8; $i++) {
            DB::Table('programs')->insert([
                'prg_userid' => random_int(1, 10),
                'prg_machineid' => random_int(1, 10),
                'prg_dateid' => random_int(1, 10),
                'prg_name' => str_random(10),
                'prg_type' => "custom",
                'prg_water' => random_int(1, 3),
                'prg_sunshine' => random_int(30, 200),
                'prg_count' => random_int(0, 5),
                'prg_compostname' => str_random('10'),
                'prg_period' => random_int(5, 7)
            ]);
        }
    }
}
