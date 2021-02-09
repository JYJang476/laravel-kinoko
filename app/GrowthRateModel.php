<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrowthRateModel extends Model
{
    protected $table = 'Growth_rates';
    protected $primaryKey = 'id';

    protected $fillable = [
        'gr_userid', 'gr_prgid', 'gr_value'
    ];

    public function members() {
        return $this->belongsTo('App\UserModel', gr_userid);
    }
}
