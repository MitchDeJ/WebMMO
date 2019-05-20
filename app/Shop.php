<?php

namespace App;

use App\Http\Controllers\NpcController;
use Illuminate\Database\Eloquent\Model;
use App\ShopItem;

class Shop extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function getItems() {
        $items = ShopItem::where('shop_id', $this->id)->get();
        return $items;


    }

    public function wantsItem($itemId) {
        $matches = ShopItem::where('item_id', $itemId)
            ->where('shop_id', $this->id)->get();

        if (count($matches) > 0)
            return true;
    }

    public function isInArea($areaId) {
        $id = $this->id;
        $npcs = Npc::where('area_id', $areaId)->get();

        foreach($npcs as $npc) {
            if (NpcController::getShop($npc->id) == $id)
                return true;
        }
        return false;
    }
}
