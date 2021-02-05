<?php

use Illuminate\Database\Seeder;

class delete_datas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 7; $i++) {
            DB::Table('setting_datas')->insert([
                'setting_prgid' => 8,
                'setting_value' => random_int(30, 35),
                'setting_type' => "temperature",
                'setting_date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "2020-10-11 02:58:11")
                    ->addDay($i - 1)
                    ->format('Y-m-d h:i:s')
            ]);
            DB::Table('setting_datas')->insert([
                'setting_prgid' => 8,
                'setting_value' => random_int(30, 35),
                'setting_type' => "humidity",
                'setting_date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "2020-10-11 02:58:11")
                    ->addDay($i - 1)
                    ->format('Y-m-d h:i:s')
            ]);
        }
    }
}
