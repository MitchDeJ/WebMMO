<?php

use Illuminate\Database\Seeder;

class LootTableDropSeeder extends Seeder
{
    public function run()
    {
        /*LOOT TABLE [1]*/
        $this->addDrop(1, 11, 1, 1, 10); // 1 apple
        $this->addDrop(1, 4, 1, 2, 10); //1 - 2 logs
        $this->addDrop(1, 13, 1, 1, 10); // 1 knife
        $this->addDrop(1, 17, 1, 25, 12); // 1-25 coins
        $this->addDrop(1, 23, 1, 1, 4); // 1 bronze bar

        /*LOOT TABLE [2]*/
        $this->addDrop(2, 21, 1, 3, 10); //1 - 3 copper
        $this->addDrop(2, 22, 1, 3, 10); //1 - 3 tin
        $this->addDrop(2, 20, 1, 1, 1); // 1 pickaxe
        $this->addDrop(2, 23, 1, 3, 2); // 1 - 3 bronze bar

        /*LOOT TABLE [3]*/
        $this->addDrop(3, 23, 1, 3, 2); // 1 - 3 bronze bar
        $this->addDrop(3, 10, 1, 1, 1); // 1 amulet
        $this->addDrop(3, 19, 1, 1, 1); // 1 dark bow
        $this->addDrop(3, 17, 1, 500, 10); // 1-500 coins

    }

    public function addDrop($table, $itemId, $min, $max, $weight) {
        DB::table('loot_table_drops')->insert([
            'table_id' => $table,
            'item_id' => $itemId,
            'min_amount' => $min,
            'max_amount' => $max,
            'weight' => $weight
        ]);
    }
}
