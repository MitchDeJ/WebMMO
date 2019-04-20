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
                return array('Example Area', 'This is an example area.');
            case 2:
                return array('Another Example Area', 'This is another example area.');

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
