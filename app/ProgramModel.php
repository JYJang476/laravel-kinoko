<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramModel extends Model
{
    protected $table = 'Programs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected  $fillable = [
        'prg_userid', 'prg_machineid', 'prg_dateid', 'prg_name', 'prf_type',
        'prg_water', 'prg_sunshine', 'prg_count', 'prg_compostname', 'prg_period'
    ];

    public function members() {
        return $this->belongsTo('App\UserModel', 'prg_userid');
    }

    public function mushrooms() {
        return $this->hasMany('App\MushroomModel', 'mr_prgid');
    }

    public function setting_datas() {
        return $this->hasMany('App\SettingModel', 'setting_prgid');
    }
}
