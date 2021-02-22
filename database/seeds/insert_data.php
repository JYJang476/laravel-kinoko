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
        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-06 05:58:11');

        $endDate = clone $date;
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-12 05:58:11');

        while($date->day < $endDate->day){
            $date->addHour(1);
            DB::table('Datas')->insert([
                'prgid' => 9,
                'value' => random_int(15, 35),
                'type' => 'temperature',
                'date' => $date
            ]);

            DB::table('Datas')->insert([
                'prgid' => 9,
                'value' => random_int(15, 35),
                'type' => 'humidity',
                'date' => $date
            ]);
        }

    
    }
}
