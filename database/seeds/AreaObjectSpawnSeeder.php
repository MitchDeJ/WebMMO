<?php

use Illuminate\Database\Seeder;

class AreaObjectSpawnSeeder extends Seeder
{
    public function run()
    {
        //cooking range in area 1
        $this->spawn(1, 1);
    }

    public function spawn($mobId, $areaId) {
        DB::table('area_object_spawns')->insert([
            'object_id' => $mobId,
            'area_id' => $areaId,
        ]);
    }
}
