<?php

use Illuminate\Database\Seeder;

class SkillSpotSeeder extends Seeder
{
    //constants
    public $NAME = 0;
    public $AREA_ID = 1;
    public $SKILL_ID = 2;
    public $XP_AMOUNT = 3;
    public $ITEM_ID = 4;
    public $COOLDOWN = 5;

    /*
     * skillspot definitions
     */
    public function skillSpotDefinition($skillSpotId) {
        switch ($skillSpotId) {
            case 1:
                return array('Generic Forest', 1, 1, 10, 1, 10);
            case 2:
                return array('Generic Sea', 1, 2, 15, 1, 20);

            default:
                return -1;
        }
    }

    public function getSkillSpotCount() {
        $count = 0;
        for ($i = 1; $this->skillSpotDefinition($i) != -1; $i+=1) {
            $count = $i;
        }
        return $count;
    }

    public function run()
    {
        for ($i = 1; $i <= $this->getSkillSpotCount(); $i += 1) {
            DB::table('skillspots')->insert([
                'id' => $i,
                'name' => $this->skillSpotDefinition($i)[$this->NAME],
                'area_id' => $this->skillSpotDefinition($i)[$this->AREA_ID],
                'skill_id' => $this->skillSpotDefinition($i)[$this->SKILL_ID],
                'xp_amount' => $this->skillSpotDefinition($i)[$this->XP_AMOUNT],
                'item_id' => $this->skillSpotDefinition($i)[$this->ITEM_ID],
                'cooldown' => $this->skillSpotDefinition($i)[$this->COOLDOWN],
            ]);
        }
    }
}
