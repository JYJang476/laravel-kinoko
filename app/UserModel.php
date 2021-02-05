<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'user_email', 'user_date', 'user_lastlogout', 'user_machineid', 'token'
    ];

    public function programs() {
        return $this->hasMany('App\ProgramModel', 'prg_userid');
    }

    public function machines() {
        return $this->hasMany('App\MachineModel', 'machine_userid');
    }

    public function dates() {
        return $this->hasMany('App\DateModel', 'date_userid');
    }

    public function growth_rates() {
        return $this->hasMany('App\GrowthRateModel', 'gr_userid');
    }

    public function compost_images() {
        return $this->hasMany('App\CompostImageModel', 'compostimg_userid');
    }
}




//public function InsertUserData(Array $userData) {
//    $result = $this->insert($userData);
//    return $result;
//}
//
//public function SelectUserData($id) {
//    $result = $this->where('user_id', $id)->first();
//    return $result;
//}
//
//public function UpdateUserData($id, Array $updateData) {
//    $result = $this->where('id', $id)->update($updateData);
//    return $result;
//}
