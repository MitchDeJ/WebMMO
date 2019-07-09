<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coinflip extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'bet'
    ];
}
