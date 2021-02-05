<?php

use Illuminate\Database\Seeder;

class PinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10개의 핀 번호 데이터 추가
        for($i = 0; $i < 10; $i++) {
            DB::Table('pins')->insert([
                'pin_value' => random_int(100000, 999999),
                'pin_machineid' => random_int(1, 10),
                'pin_pw' => str_random(12)
            ]);
        }
    }
}
