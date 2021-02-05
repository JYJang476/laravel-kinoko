<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineModel extends Model
{
    protected $table = 'machines';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'machine_userid', 'machine_prgid', 'machine_pin', 'machine_ison', 'machine_ip', "machine_ispresence"
    ];

    public function pins() {
        return $this->hasOne('App\PinModel', 'pin_machineid');
    }

    public function members() {
        return $this->belongsTo('App\UserModel', 'machine_userid');
    }
}
