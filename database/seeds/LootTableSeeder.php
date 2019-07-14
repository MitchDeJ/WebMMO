<?php

use Illuminate\Database\Seeder;

class LootTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //make loot table 1 dropped by mob 1 (guard)
        $this->setLootTable(1, 1);

        $this->setLootTable(2, 2);

        $this->setLootTable(3, 3);
    }

    public function setLootTable($id, $mobId) {
        DB::table('loot_tables')->insert([
            'table_id' => $id,
            'mob_id' => $mobId,
        ]);
    }
}
