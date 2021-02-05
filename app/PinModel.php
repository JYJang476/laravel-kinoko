<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinModel extends Model
{
    protected $table = 'pins';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        "pin_value", "pin_machineid", "pin_pw"
    ];

    public function machines() {
        return $this->belongsTo('App\MachineModel', 'pin_machineid');
    }
}
