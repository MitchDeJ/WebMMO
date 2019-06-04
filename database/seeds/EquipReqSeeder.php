<?php

use Illuminate\Database\Seeder;
use App\Constants;

class EquipReqSeeder extends Seeder
{
    public function run()
    {
        //dark bow
        $this->req(19, Constants::$RANGED, 50);
    }

    public function req($itemId, $skillId, $level) {
        DB::table('equip_reqs')->insert([
            'item_id' => $itemId,
            'skill_id' => $skillId,
            'level' => $level
        ]);
    }
}
