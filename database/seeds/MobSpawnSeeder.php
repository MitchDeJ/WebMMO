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
        //guard in village
        $this->spawn(1, 1);
        //rock golem in mining camp
        $this->spawn(2, 4);
        //dark beast near merchant
        $this->spawn(3, 5);
    }

    public function spawn($mobId, $areaId) {
        DB::table('mob_spawns')->insert([
            'mob_id' => $mobId,
            'area_id' => $areaId,
        ]);
    }
}
