<?php

use Illuminate\Database\Seeder;

class mush_add extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $types = [ 'complete', 'harvest', 'whiteflower', 'growing' ];
//
//        for($i = 0; $i < 5; $i++)
//            DB::table('Mushrooms')->insert([
//                'mr_prgid' => 3,
//                'mr_size' => random_int(1, 7),
//                'mr_imgid' => 0,
//                'mr_status' => $types[random_int(0, 3)],
//                'mr_growthrate' => random_int(10, 90),
//            ]);
        $types = [ 'complete', 'harvest', 'whiteflower', 'growing' ];

        for($i = 0; $i < 5; $i++)
            DB::table('Mushrooms')->insert([
                'mr_prgid' => 55,
                'mr_size' => random_int(1, 7),
                'mr_imgid' => 0,
                'mr_status' => $types[random_int(0, 3)],
                'mr_growthrate' => random_int(10, 90),
            ]);
    }
}
