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
        $this->point(1, 50, 8);
        $this->point(2, 57, 140);
        $this->point(3, 155, 16);
        $this->point(4, 170, 165);
        $this->point(5, 175, 57);
    }

    public function point($areaId, $x, $y) {
        DB::table('map_points')->insert([
            'area_id' => $areaId,
            'x' => $x,
            'y' => $y
        ]);
    }
}