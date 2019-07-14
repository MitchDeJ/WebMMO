<?php

use Illuminate\Database\Seeder;

class AreaObjectSpawnSeeder extends Seeder
{
    public function run()
    {

        //village (1)
        $this->spawn(1, 1); //cooking range
        $this->spawn(4, 1); //Bank chest
        $this->spawn(3, 1); //trading post

        //lumberyard (2)
        $this->spawn(2, 2); //fletching table

        //Mining camp (4)
        $this->spawn(5, 4); //furnace
        $this->spawn(6, 4); //anvil

        //Mysterious tent (5)
        $this->spawn(7, 5); //coinflip table
    }

    public function spawn($objId, $areaId) {
        DB::table('area_object_spawns')->insert([
            'object_id' => $objId,
            'area_id' => $areaId,
        ]);
    }
}
