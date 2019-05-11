<?php

use Illuminate\Database\Seeder;

class MobSeeder extends Seeder
{
    //constants
    public $NAME = 0;
    public $MELEE = 1;
    public $RANGED = 2;
    public $MAGIC = 3;
    public $DEFENCE = 4;
    public $HP = 5;
    public $ATTACK_SPEED = 6;
    public $RESPAWN = 7;

    /*
     * Mob definitions
     */
    public function mobDefinition($npcId) {
        switch ($npcId) {
            case 1:
                return array('Giant Rat', 1, 1, 1, 1, 5, 2, 5);


            default:
                return -1;
        }
    }

    public function getMobCount() {
        $count = 0;
        for ($i = 1; $this->mobDefinition($i) != -1; $i+=1) {
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
        for ($i = 1; $i <= $this->getMobCount(); $i += 1) {
            DB::table('mobs')->insert([
                'id' => $i,
                'name' => $this->mobDefinition($i)[$this->NAME],
                'melee' => $this->mobDefinition($i)[$this->MELEE],
                'ranged' => $this->mobDefinition($i)[$this->RANGED],
                'magic' => $this->mobDefinition($i)[$this->MAGIC],
                'defence' => $this->mobDefinition($i)[$this->DEFENCE],
                'hitpoints' => $this->mobDefinition($i)[$this->HP],
                'attack_speed' => $this->mobDefinition($i)[$this->ATTACK_SPEED],
                'respawn' => $this->mobDefinition($i)[$this->RESPAWN]
            ]);
        }
    }
}
