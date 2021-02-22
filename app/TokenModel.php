<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    protected $table = 'token';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_no', 'date', 'token'
    ];

    public function User() {
        return $this->hasOne('App\UserModel', 'user_no');
    }
}
