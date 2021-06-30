<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class helpModel extends Model
{
    protected $table = "Help";
    protected $primaryKey = "id";
    protected $fillable = [
        "name", "effect", "enviroment", "thumnail", "date"
    ];
}
