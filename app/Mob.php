<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mob extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'melee', 'ranged', 'magic', 'defence', 'hitpoints', 'attack_speed'
    ];

    public function getLootTable() {
        $table= LootTable::where('mob_id', $this->id)->get()->first();
        return $table;
    }
}
