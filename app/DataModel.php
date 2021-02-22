<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{
    protected $table = 'Datas';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'prgid', 'value', 'type', 'date'
    ];
}
