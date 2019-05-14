<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDialogue extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
        'user_id', 'dialogue_id'
    ];
}
