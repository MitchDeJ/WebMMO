<?php

use Illuminate\Database\Seeder;

class AreaObjectSpawnSeeder extends Seeder
{
    public function run()
    {
        //cooking range in area 1
        $this->spawn(1, 1);
        //fletching table in area 1
        $this->spawn(2, 1);
    }

    public function spawn($objId, $areaId) {
        DB::table('area_object_spawns')->insert([
            'object_id' => $objId,
            'area_id' => $areaId,
        ]);
    }
}
