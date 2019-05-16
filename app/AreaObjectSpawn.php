<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaObjectSpawn extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id', 'area_id'
    ];
}
