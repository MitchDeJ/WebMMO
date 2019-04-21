<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xp_amount', 'skill_id', 'player_id'
    ];
}
