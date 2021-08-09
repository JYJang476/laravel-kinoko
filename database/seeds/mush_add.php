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
        $rots = [0, 90, 180, 270];

        for($i = 0; $i < 10; $i++) {
            $metadata = json_encode([
                'rotation' => $rots[random_int(0, 3)],
                'x' => random_int(5, 10),
                'y' => random_int(5, 10),
                'width' => random_int(5, 10),
                'height' => random_int(5, 10)
            ]);
            DB::table('Mushrooms')->insert([
                'mr_prgid' => 80,
                'mr_size' => random_int(1, 7),
                'mr_imgid' => 0,
                'mr_status' => $types[random_int(0, 3)],
                'mr_growthrate' => random_int(10, 90),
                'mr_metadata' => $metadata
            ]);
        }
    }
}
