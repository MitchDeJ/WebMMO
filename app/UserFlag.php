<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFlag extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
        'user_id', 'flag', 'value'
    ];
}
