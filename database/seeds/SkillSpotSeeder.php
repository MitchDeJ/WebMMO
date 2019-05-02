<?php

use Illuminate\Database\Seeder;
use App\Constants;

class SkillSpotSeeder extends Seeder
{
    //constants
    public $NAME = 0;
    public $AREA_ID = 1;
    public $SKILL_ID = 2;
    public $XP_AMOUNT = 3;
    public $ITEM_ID = 4;
    public $AMOUNT_MIN = 5;
    public $AMOUNT_MAX = 6;
    public $COOLDOWN = 7;

    /*
     * skillspot definitions
     */
    public function skillSpotDefinition($skillSpotId) {
        switch ($skillSpotId) {
            case 1:
                return array('Generic Forest', 1, Constants::$WOODCUTTING, 2, 4, 1, 10, 2);
            case 2:
                return array('Generic Sea', 1, Constants::$FISHING, 3, 3, 1, 10, 5);
            case 3:
                return array('Ultra Rare Tree', 1, Constants::$WOODCUTTING, 25, 4, 1, 5, 30);

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
                'amount_min' => $this->skillSpotDefinition($i)[$this->AMOUNT_MIN],
                'amount_max' => $this->skillSpotDefinition($i)[$this->AMOUNT_MAX],
                'cooldown' => $this->skillSpotDefinition($i)[$this->COOLDOWN],
            ]);
        }
    }
}
