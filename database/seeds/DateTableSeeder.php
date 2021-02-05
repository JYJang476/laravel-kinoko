<?php

use Illuminate\Database\Seeder;

class DateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = DB::Table('programs')->get();
        foreach($period as $program) {
            DB::Table('dates')->insert([
                'date_userid' => random_int(1, 10),
                'date_start' => \Carbon\Carbon::now(),
                'date_end' => \Carbon\Carbon::now()->addDay($program->prg_period)->format('Y-m-d H:i:s')
            ]);
        }
    }
}
