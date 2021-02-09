<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'Users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id', 'user_id', 'user_email', 'user_date', 'user_logout', 'token'
    ];
}
