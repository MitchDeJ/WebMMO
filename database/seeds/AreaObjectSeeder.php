<?php

use Illuminate\Database\Seeder;

class AreaObjectSeeder extends Seeder
{
    public function run()
    {
        $this->addObject(1, 'Cooking range');
        $this->addObject(2, 'Fletching table');
        $this->addObject(3, 'Trading post');
        $this->addObject(4, 'Bank chest');
    }

    public function addObject($objectId, $name) {
        DB::table('area_objects')->insert([
            'id' => $objectId,
            'name' => $name,
        ]);
    }
}
