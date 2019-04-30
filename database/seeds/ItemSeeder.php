<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{

    //constants
    public $NAME = 0;
    public $DESCRIPTION = 1;
    public $ICON = 2;
    public $STACKABLE = 3;


    /*
     * Item definitions
     */
    public function itemDefinition($itemId) {
        switch ($itemId) {
            case 1:
                return array('Axe', 'Used to cut wood.', 'axe', false);
            case 2:
                return array('Fishing rod', 'Used to fish.', 'fishingrod', false);
            case 3:
                return array('Fish', 'Great source of protein.', 'fish', true);
            case 4:
                return array('Logs', 'Cut from a tree.', 'log', true);
            case 5:
                return array('Helm', 'Protects your head.', 'helm', false);
            case 6:
                return array('Platebody', 'Protects your body.', 'platebody', false);
            case 7:
                return array('Platelegs', 'Protects your legs.', 'platelegs', false);
            case 8:
                return array('Sword', 'Good for cutting stuff.', 'sword', false);
            case 9:
                return array('Shield', 'Used for protecting yourself.', 'shield', false);
            case 10:
                return array('Amulet', 'A magical amulet.', 'amulet', false);


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
                'icon' => $this->itemDefinition($i)[$this->ICON],
                'stackable' => $this->itemDefinition($i)[$this->STACKABLE]
            ]);
        }
    }
}
