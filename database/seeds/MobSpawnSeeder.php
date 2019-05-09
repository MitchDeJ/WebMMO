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
        DB::table('mob_spawns')->insert([
            'mob_id' => 1,
            'area_id' => 1,
        ]);

    }
}
