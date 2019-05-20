<?php

use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public $ITEM_ID = 0;
    public $STOCK = 1;
    public $SELL = 2;
    public $BUY = 3;

    public function run()
    {
        //test shop
        $this->shop(1, "Bob's Test Shop", array(
            array(5, 10, 750, 150),
            array(6, 10, 1000, 250),
            array(7, 10, 1000, 250)
        ));
    }

    public function shop($shopId, $name, array $items)
    {
        DB::table('shops')->insert([
            'id' => $shopId,
            'name' => $name
        ]);
        foreach ($items as $i) {
            DB::table('shop_items')->insert([
                'shop_id' => $shopId,
                'item_id' => $i[$this->ITEM_ID],
                'stock' => $i[$this->STOCK],
                'sell_price' => $i[$this->SELL],
                'buy_price' => $i[$this->BUY],
            ]);
        }
    }
}
