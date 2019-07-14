<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    //constants
    public $NAME = 0;
    public $DESCRIPTION = 1;

    /*
     * Area definitions
     */
    public function areaDefinition($areaId) {
        switch ($areaId) {
            case 1:
                return array('Village', 'A small village.');
            case 2:
                return array('Lumberyard', 'There are many trees around here.');
            case 3:
                return array('Fishing docks', 'People fish here.');
            case 4:
                return array('Mining camp', 'There are many rocks around here.');
            case 5:
                return array("Mysterious tent", "I wonder what's inside.");

            default:
                return -1;
        }
    }

    public function getAreaCount() {
        $count = 0;
        for ($i = 1; $this->areaDefinition($i) != -1; $i+=1) {
            $count = $i;
        }
        return $count;
    }

    public function run()
    {
        for ($i = 1; $i <= $this->getAreaCount(); $i += 1) {
            DB::table('areas')->insert([
                'id' => $i,
                'name' => $this->areaDefinition($i)[$this->NAME],
                'description' => $this->areaDefinition($i)[$this->DESCRIPTION],
            ]);
        }
    }
}
