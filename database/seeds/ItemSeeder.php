<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{

    //constants
    public $NAME = 0;
    public $DESCRIPTION = 1;
    public $ICON = 2;


    /*
     * Item definitions
     */
    public function itemDefinition($itemId) {
        switch ($itemId) {
            case 1:
                return array('Example item', 'This is an example item.', 'example');

            default:
                return -1;
        }
    }

    public function getItemCount() {
        $count = 0;
        for ($i = 1; $this->itemDefinition($i) != -1; $i+=1) {
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
        for ($i = 1; $i <= $this->getItemCount(); $i += 1) {
            DB::table('items')->insert([
                'id' => $i,
                'name' => $this->itemDefinition($i)[$this->NAME],
                'description' => $this->itemDefinition($i)[$this->DESCRIPTION],
                'icon' => $this->itemDefinition($i)[$this->ICON]
            ]);
        }
    }
}
