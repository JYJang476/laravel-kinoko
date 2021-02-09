<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompostImageModel extends Model
{
    protected $table = 'Compost_images';
    protected $primaryKey = 'id';

    protected $fillable = [
        'compostimg_userid', 'compostimg_url', 'compostimg_date'
    ];

    public function members() {
        return $this->belongsTo('App\UserModel', 'compostimg_userid');
    }
}
