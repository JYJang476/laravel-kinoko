<?php

use Illuminate\Database\Seeder;

class insert_data extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        for($i = 3; $i < 8; $i++) {
//            $pin = random_int(100000, 200000);
//            DB::table('Machines')->insert([
//                'machine_userid' => 0,
//                'machine_prgid' => 0,
//                'machine_pin' => $pin
//            ]);
//
//            DB::table('Pins')->insert([
//                'pin_value' => $pin,
//                'pin_machineid' => $i,
//                'pin_pw' => "1234"
//            ]);
//        }
        for($i = 0; $i < 10; $i++) {
            DB::table('Datas')->insert([
                'prgid' => 55,
                'value' => random_int(20, 30),
                'type' => 'temperature',
                'date' => \Carbon\Carbon::now()->addHour($i)
            ]);
            DB::table('Datas')->insert([
                'prgid' => 55,
                'value' => random_int(70, 80),
                'type' => 'humidity',
                'date' => \Carbon\Carbon::now()->addHour($i)
            ]);
        }
    }
}
