<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    public function hasNpc($npcId) {
        $amt = Npc::where('area_id', $this->id)
            ->where('id', $npcId)->get();

        if (count($amt) > 0)
            return true;

        return false;
    }
}
