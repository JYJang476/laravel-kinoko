<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateModel extends Model
{
    protected $table = 'Dates';
    protected $primaryKey = 'date_id';

    protected $fillable = [
        'date_userid', 'date_start', 'date_start', 'date_end'
    ];

    public function users() {
        return $this->belongsTo('App\UserModel', 'date_userid');
    }
}
