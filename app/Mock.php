<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mock extends Model
{
    protected $table = 'mock';
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'url', 'date'
    ];
}
