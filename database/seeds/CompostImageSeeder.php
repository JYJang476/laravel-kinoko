<?php

use Illuminate\Database\Seeder;

class CompostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 버섯 10개에 개당 5개의 목업 이미지 데이터 생성
        $mushrooms = DB::Table('mushrooms')->get();
        foreach ($mushrooms as $mushroom) {
            for ($i = 0; $i < 5; $i++) {
                DB::Table('compost_images')->insert([
                    'compostimg_userid' => $mushroom->id,
                    'compostimg_url' => '',
                    'compostimg_date' => \Carbon\Carbon::now()->addDay($i)
                ]);
            }
        }
    }
}
