<?php

namespace App;

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
}
