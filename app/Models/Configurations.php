<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configurations extends Model
{
    protected $table = 'configurations';
    public $timestamps = false;
    protected $fillable = [
        'type','value'
    ];


}
