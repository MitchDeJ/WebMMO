<?php

use Illuminate\Database\Seeder;

class MobSpawnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //giant rat in area 1
        $this->spawn(1, 1);
    }

    public function spawn($mobId, $areaId) {
        DB::table('mob_spawns')->insert([
            'mob_id' => $mobId,
            'area_id' => $areaId,
        ]);
    }
}
