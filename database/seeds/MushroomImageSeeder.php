<?php

use Illuminate\Database\Seeder;

class MushroomImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 각 버섯 마다 5개의 버섯 이미지를 생성
        $mushrooms = DB::Table('mushrooms')->get();
        foreach ($mushrooms as $mushroom) {
            for ($i = 0; $i < 5; $i++) {
                DB::Table('mushroom_images')->insert([
                    'mushimg_mrid' => $mushroom->id,
                    'mushimg_url' => '',
                    'mushimg_date' => $i + 1
                ]);
            }
        }
    }
}
