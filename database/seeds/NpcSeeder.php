<?php

use Illuminate\Database\Seeder;

class NpcSeeder extends Seeder
{
    //constants
    public $NAME = 0;
    public $AREA = 1;

    /*
     * NPC definitions
     */
    public function npcDefinition($npcId) {
        switch ($npcId) {
            case 1:
                return array('Bob', 1);
            case 2:
                return array('Arran', 1);


            default:
                return -1;
        }
    }

    public function getNpcCount() {
        $count = 0;
        for ($i = 1; $this->npcDefinition($i) != -1; $i+=1) {
            $count = $i;
        }
        return $count;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= $this->getNpcCount(); $i += 1) {
            DB::table('npcs')->insert([
                'id' => $i,
                'name' => $this->npcDefinition($i)[$this->NAME],
                'area_id' => $this->npcDefinition($i)[$this->AREA],
            ]);
        }
    }
}
