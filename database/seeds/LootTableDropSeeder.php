<?php

use Illuminate\Database\Seeder;

class LootTableDropSeeder extends Seeder
{
    public function run()
    {
        /*LOOT TABLE [1] (Giant Rat)*/
        $this->addDrop(1, 11, 1, 1, 10); // 1 apple
        $this->addDrop(1, 4, 1, 10, 20); //1 - 10 logs

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
