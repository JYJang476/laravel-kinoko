<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 날짜 데이터 받아와서 날짜 당 설정 데이터 삽입
        $programs = DB::Table('programs')->select("programs.id", "dates.date_start", "programs.prg_type", "programs.prg_period")
                                         ->join('dates', 'programs.prg_dateid', '=', 'dates.id')->get();
        foreach ($programs as $program) {
            if($program->prg_type != 'custom')
                continue;
            for($i = 1; $i <= $program->prg_period; $i++){
                $setting = DB::Table('setting_datas');
                $setting->insert([
                    'setting_prgid' => $program->id,
                    'setting_value' => random_int(30, 35),
                    'setting_type' => "temperature",
                    'setting_date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $program->date_start)
                                            ->addDay($i - 1)
                                            ->format('Y-m-d h:i:s')
                ]);
                $setting->insert([
                    'setting_prgid' => $program->id,
                    'setting_value' => random_int(10, 20),
                    'setting_type' => "humidity",
                    'setting_date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $program->date_start)
                                            ->addDay($i - 1)
                                            ->format('Y-m-d h:i:s')
                ]);
            }
        }
    }

    //        $types = ["temperature", "humidity"];
//        for($i = 0; $i < 10; $i++) {
//            DB::Table('setting_datas')->insert([
//                'setting_prgid' => random_int(0, 10),
//                'setting_value' => random_int(10, 30),
//                'setting_type' => $types[random_int(0, 1)],
//            ]);
//        }
}
