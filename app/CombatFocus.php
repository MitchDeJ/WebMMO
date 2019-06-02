<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CombatFocus extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database
    public $table = 'combat_focus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'focus_type'
    ];
}
