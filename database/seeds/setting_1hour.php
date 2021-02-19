<?php

use Illuminate\Database\Seeder;

class setting_1hour extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseDate = \Carbon\Carbon::createFromFormat("Y-m-d H:i:s","2020-12-06 00:58:11");
        $endDate = clone $baseDate;
        $endDate = $endDate->addDay(5)->addHour(17);


        while($baseDate->day < $endDate->day){
            $baseDate->addHour(1);
            DB::table('Setting_datas')->insert([
                'setting_prgid' => 9,
                'setting_value' => random_int(15, 35),
                'setting_type' => 'temperature',
                'setting_date' => $baseDate
            ]);

            DB::table('Setting_datas')->insert([
                'setting_prgid' => 9,
                'setting_value' => random_int(15, 35),
                'setting_type' => 'humidity',
                'setting_date' => $baseDate
            ]);
        }

    }
}
