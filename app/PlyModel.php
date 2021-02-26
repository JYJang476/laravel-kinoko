<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlyModel extends Model
{
    protected $table = '3ddata';
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'url', 'machineid', 'date'
    ];
}
