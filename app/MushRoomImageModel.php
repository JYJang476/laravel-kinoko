<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MushRoomImageModel extends Model
{
    protected $table = 'Mushroom_images';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mushimg_mrid', 'mushimg_url', 'mushimg_date', 'mrimg_date'
    ];

    public function mushrooms() {
        return $this->belongsTo('App\MushroomModel', 'mushimg_mrid');
    }
}
