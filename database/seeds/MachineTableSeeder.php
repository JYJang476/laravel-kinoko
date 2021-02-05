<?php

use Illuminate\Database\Seeder;

class MachineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10개의 기기 데이터를 추가
        for($i = 0; $i < 10; $i++) {
            DB::Table('machines')->insert([
                'machine_userid' => 7,
                'machine_prgid' => random_int(0, 10),
                'machine_pin' => 0,
                'machine_ip' => str_random(3).".".str_random(3).
                    str_random(3).str_random(3),
                'machine_name' => str_random(10)
            ]);
        }
    }

//for($i = 1; $i < 15; $i++)
//DB::Table('machines')->where('id', $i)->update([
//'machine_name' => str_random(10)
//]);
}
