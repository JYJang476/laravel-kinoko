<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    protected $table = 'Setting_datas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'setting_prgid', 'setting_value', 'setting_type', 'setting_date'
    ];

    public function programs() {
        return $this->belongsTo('App\ProgramModel', 'setting_prgid');
    }
}
