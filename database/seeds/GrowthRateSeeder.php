<?php

use Illuminate\Database\Seeder;

class GrowthRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 각 프로그램의 재배일수 만큼 랜덤으로 생장률 데이터를 집어넣는다.
        $programs = DB::Table('programs')->get();
        foreach ($programs as $program) {
            $growth = 0;
            for($i = 1; $i <= $program->prg_period; $i++){
                $growth += random_int(5, 15);
                DB::Table('growth_rates')->insert([
                    'gr_userid' => $program->prg_userid,
                    'gr_prgid' => $program->id,
                    'gr_value' => $growth
                ]);
            }
        }
    }
}
