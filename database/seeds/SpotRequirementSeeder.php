<?php

use Illuminate\Database\Seeder;
use App\Constants;

class SpotRequirementSeeder extends Seeder
{
    //constants
    public $SPOT_ID = 0;
    public $SKILL_ID = 1;
    public $REQUIREMENT = 2;

    /*
     * Spot Requirement definitions
     */
    public function spotReqDefinition($spotReqId) {
        switch ($spotReqId) {
            case 1:
                return array(1, Constants::$WOODCUTTING, 1);
            case 2:
                return array(2, Constants::$FISHING, 1);
            case 3:
                return array(3, Constants::$MINING, 1);
            case 4:
                return array(4, Constants::$MINING, 1);


            default:
                return -1;
        }
    }

    public function getSpotReqCount() {
        $count = 0;
        for ($i = 1; $this->spotReqDefinition($i) != -1; $i+=1) {
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
        for ($i = 1; $i <= $this->getSpotReqCount(); $i += 1) {
            DB::table('spotrequirements')->insert([
                'id' => $i,
                'spot_id' => $this->spotReqDefinition($i)[$this->SPOT_ID],
                'skill_id' => $this->spotReqDefinition($i)[$this->SKILL_ID],
                'requirement' => $this->spotReqDefinition($i)[$this->REQUIREMENT]
            ]);
        }
    }
}
