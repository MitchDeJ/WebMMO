<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id', 'item_id', 'stock', 'sell_price', 'buy_price'
    ];

    public function isInShop($shopId) {
        $shop = Shop::find($shopId);
        if (!$shop)
            return false;

        if ($shopId == $this->shop_id)
            return true;

        return false;
    }
}
