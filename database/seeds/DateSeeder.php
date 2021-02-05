<?php

use Illuminate\Database\Seeder;

class DateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10개의 날짜 데이터를 입력
        for($i = 0; $i < 10; $i++) {
            $period = DB::Table('programs')->where('id', $i)->first()->prg_period;
            DB::Table('dates')->insert([
                'date_userid' => random_int(1, 10),
                'date_end' => \Carbon\Carbon::now()->addDay($period)->format('Y-m-d H:i:s')
            ]);
        }
    }
}
