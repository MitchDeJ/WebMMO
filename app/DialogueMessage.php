<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DialogueMessage extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
        'dialogue_id', 'actor', 'text'
    ];
}
