<?php

namespace App;

use App\Http\Controllers\ObjectController;
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

    public function hasObject($objId) {
        $amt = AreaObjectSpawn::where('area_id', $this->id)
            ->where('object_id', $objId)->get();

        if (count($amt) > 0)
            return true;

        return false;
    }

    public function hasMarketObject() {
        $amt = AreaObjectSpawn::where('area_id', $this->id)->get();

        if (count($amt) == 0)
            return false;

        foreach($amt as $obj) {
             if (ObjectController::opensMarket($obj->object_id))
                 return true;
        }

        return false;
    }
}
