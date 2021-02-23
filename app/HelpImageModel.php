<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpImageModel extends Model
{
    protected $table = "help_image";
    protected $primaryKey = "id";
    public $timestamps = false;
    
    protected $fillable = [
        "url", "date"
    ];
}
