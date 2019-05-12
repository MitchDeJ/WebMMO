<?php

use Illuminate\Database\Seeder;

class MapPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->point(1, 45, 10);
        $this->point(2, 18, 80);
    }

    public function point($areaId, $x, $y) {
        DB::table('map_points')->insert([
            'area_id' => $areaId,
            'x' => $x,
            'y' => $y
        ]);
    }
}