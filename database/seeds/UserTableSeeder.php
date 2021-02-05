<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            DB::table('Members')->insert([
                'user_id' => str_random(5) . random_int(0, 20),
                'user_email' => str_random(5) . random_int(0, 20) . "@gmail.com",
                'user_lastlogout' => '2020-12-01',
            ]);
        }
    }
}
