<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api_Tokens extends Model
{
    protected $table = "api_tokens";
    public $timestamps = false;

    protected $fillable = [
        'device_type','api_token'
    ];
}
