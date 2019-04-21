<?php

use Illuminate\Database\Seeder;

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
            case 1:
                return array('Woodcutting', 'woodcutting');
            case 2:
                return array('Fishing', 'fishing');

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
