<?php

use Illuminate\Database\Seeder;
use App\Constants;

class SkillSeeder extends Seeder
{
    //constants
    public $NAME = 0;
    public $ICON = 1;

    /*
     * Skill definitions
     */
    public function skillDefinition($skillId) {
        switch ($skillId) {
            case (Constants::$WOODCUTTING):
                return array('Woodcutting', 'woodcutting');
            case (Constants::$FISHING):
                return array('Fishing', 'fishing');
            case (Constants::$MELEE):
                return array('Melee', 'melee');
            case (Constants::$RANGED):
                return array('Ranged', 'ranged');
            case (Constants::$MAGIC):
                return array('Magic', 'magic');
            case (Constants::$DEFENCE):
                return array('Defence', 'defence');
            case (Constants::$HP):
                return array('Hitpoints', 'hp');

            default:
                return -1;
        }
    }

    public function getSkillCount() {
        $count = 0;
        for ($i = 1; $this->skillDefinition($i) != -1; $i+=1) {
            $count = $i;
        }
        return $count;
    }

    public function run()
    {
        for ($i = 1; $i <= $this->getSkillCount(); $i += 1) {
            DB::table('skills')->insert([
                'id' => $i,
                'name' => $this->skillDefinition($i)[$this->NAME],
                'icon' => $this->skillDefinition($i)[$this->ICON],
            ]);
        }
    }
}
