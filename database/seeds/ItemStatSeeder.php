<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemStatSeeder extends Seeder
{

    //constants
    public $ITEM_ID = 0;
    public $MELEE = 1;
    public $MELEE_DEFENCE = 2;
    public $RANGED = 3;
    public $RANGED_DEFENCE = 4;
    public $MAGIC = 5;
    public $MAGIC_DEFENCE = 6;


    /*
     * Item definitions
     */
    public function itemStatsDefinition($itemId) {
        switch ($itemId) {
            case 5: //helm
                return array($itemId, 0, 2, 0, 1, 0, -2);
            case 6: //platebody
                return array($itemId, 0, 5, 0, 3, 0, -5);
            case 7: //platelegs
                return array($itemId, 0, 3, 0, 2, 0, -3);
            case 8: //sword
                return array($itemId, 10, 0, 0, 0, 0, 0);
            case 9: //shield
                return array($itemId, 0, 5, 0, 3, 0, -3);
            case 10: //amulet
                return array($itemId, 0, 0, 0, 0, 5, 5);

            default:
                return -1;
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= Item::getItemCount(); $i += 1) {
            if ($this->itemStatsDefinition($i) != -1) {
                DB::table('item_stats')->insert([
                    'item_id' => $i,
                    'melee' => $this->itemStatsDefinition($i)[$this->MELEE],
                    'melee_defence' => $this->itemStatsDefinition($i)[$this->MELEE_DEFENCE],
                    'ranged' => $this->itemStatsDefinition($i)[$this->RANGED],
                    'ranged_defence' => $this->itemStatsDefinition($i)[$this->RANGED_DEFENCE],
                    'magic' => $this->itemStatsDefinition($i)[$this->MAGIC],
                    'magic_defence' => $this->itemStatsDefinition($i)[$this->MAGIC_DEFENCE],
                ]);
            }
        }
    }
}
