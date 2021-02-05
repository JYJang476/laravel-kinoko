<?php

use Illuminate\Database\Seeder;

class MushroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10개의 버섯 데이터 추가
        for($i = 0; $i < 10; $i++) {
            DB::Table('mushrooms')->insert([
                'mr_prgid' => random_int(0, 10),
                'mr_size' => random_int(1, 5),
                'mr_imgid' => random_int(0, 10),
            ]);
        }
    }
}
