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
        //merchant
        $this->shop(1, "Mysterious Merchant's Wares", array(
            array(2, 10, 100, 10), //rod
            array(13, 10, 100, 10),//knife
            array(25, 10, 100, 10),//hammer
            array(24, 10, 100, 10),//blacksmith gloves
            array(15, 10, 500, 50),//bowstring
            array(18, 10, 10, 1),//arrows
        ));

        //Adventurer store
        $this->shop(2, "Adventurer's Store", array(
            array(8, 10, 3000, 300), //sword
            array(9, 10, 3000, 300), //shield
            array(10, 10, 10000, 1000),//amulet
            array(16, 10, 7500, 750),//bow
            array(12, 10, 750, 75),//fish
            array(23, 10, 1500, 150),//bronze bar
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
