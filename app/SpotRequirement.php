<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotRequirement extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database
    public $table = 'spotrequirements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spot_id', 'skill_id', 'requirement'
    ];
}
