<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loot extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
        'user_id', 'mob_fight_id', 'item_id', 'amount'
    ];
}
