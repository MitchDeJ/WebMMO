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
                return array('Raw fish', 'I should cook this.', 'fish', true);
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
            case 11:
                return array('Apple', 'An apple a day keeps the doctor away.', 'apple', false);
            case 12:
                return array('Fish', 'Great source of protein.', 'cooked_fish', false);
            case 13:
                return array('Knife', 'Stay sharp.', 'knife', false);
            case 14:
                return array('Unstrung bow', 'I should string this.', 'unstrung_bow', false);
            case 15:
                return array('Bowstring', 'I need a bow to attach this to.', 'bowstring', false);
            case 16:
                return array('Bow', 'A nice bow made out of wood.', 'bow', false);
            case 17:
                return array('Coins', 'Money!', 'coins', true);
            case 18:
                return array('Arrow', 'Ammunition used by bows.', 'arrow', true);
            case 19:
                return array('Dark bow', 'A bow from a dark dimension.', 'dark_bow', false);


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
