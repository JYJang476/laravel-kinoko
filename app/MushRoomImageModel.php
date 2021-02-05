<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MushRoomImageModel extends Model
{
    protected $table = 'mushroom_images';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mushimg_mrid', 'mushimg_url', 'mushimg_date'
    ];

    public function mushrooms() {
        return $this->belongsTo('App\MushroomModel', 'mushimg_mrid');
    }
}
