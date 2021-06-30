<?php

use Illuminate\Database\Seeder;

class update_date extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = DB::table('Setting_datas')->where([
            'setting_prgid' => 30,
            'setting_type' => 'humidity'
        ])->get();
        
        $i = 0;

        foreach($datas as $data) {
            DB::table('Setting_datas')->where('id', '=', $data->id)->update([
                'setting_date' => \Carbon\Carbon::now()->addDay($i++)
            ]);
        }
    }
}
