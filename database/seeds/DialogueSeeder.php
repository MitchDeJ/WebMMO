<?php

use Illuminate\Database\Seeder;

class DialogueSeeder extends Seeder
{
    public $ACTOR = 0;
    public $TEXT = 1;

    public function run()
    {
        //mining instructor, gives pickaxe
        $this->dialogue(1, array(
            array("_NAME_", "Hi, what are you doing here?"),
            array("_NPC_", "I^m here to inform people about the mining skill."),
            array("_NAME_", "Interesting. Tell me more."),
            array("_NPC_", "Mining is a skill that allows players to obtain ores and gems from rocks."),
            array("_NPC_", "With ores, a player can smelt bars and make equipment using the smithing skill."),
            array("_NPC_", "In this mining camp you^ll find rocks that contain copper or tin ore."),
            array("_NPC_", "Copper and tin ore can be used to create bronze bars."),
            array("_NAME_", "OK. And what tool will I need to obtain the ores?"),
            array("_NPC_", "A pickaxe. I can see you don^t have one on you. You can use this one."),
            array("Item obtained!", "_NPC_ gives you a pickaxe."),
            array("_NAME_", "Thanks!"),
            array("_NPC_", "No problem."),
        ));

        //mining instructor, already has pickaxe
        $this->dialogue(2, array(
            array("_NAME_", "Hi, what are you doing here?"),
            array("_NPC_", "I^m here to inform people about the mining skill."),
            array("_NAME_", "Interesting. Tell me more."),
            array("_NPC_", "Mining is a skill that allows players to obtain ores and gems from rocks."),
            array("_NPC_", "With ores, a player can smelt bars and make equipment using the smithing skill."),
            array("_NPC_", "In this mining camp you^ll find rocks that contain copper or tin ore."),
            array("_NPC_", "Copper and tin ore can be used to create bronze bars."),
            array("_NPC_", "I can see you already have a pickaxe on you. Good luck!"),
            array("_NAME_", "Thanks!"),
        ));

        //WC instructor, gives axe
        $this->dialogue(3, array(
            array("_NAME_", "Hi, who are you and what are you doing here?"),
            array("_NPC_", "Hello. My name is Colin wood, I^m the woodcutting instructor."),
            array("_NPC_", "I^m here to inform people about the woodcutting skill."),
            array("_NAME_", "Interesting. Tell me more."),
            array("_NPC_", "Woodcutting is a skill that allows players to obtain logs from trees."),
            array("_NPC_", "Players can then make bows and other items from the logs using the fletching skill."),
            array("_NPC_", "As you can see there^s plenty of trees around here."),
            array("_NPC_", "Try to cut them down for some logs!."),
            array("_NAME_", "Ehm.. how will I do that?"),
            array("_NPC_", "You^ll need an axe. You can use this one."),
            array("Item obtained!", "_NPC_ gives you an axe."),
            array("_NAME_", "Thanks!"),
            array("_NPC_", "No problem _NAME_, good luck."),
        ));

        //WC instructor, already has axe
        $this->dialogue(4, array(
            array("_NAME_", "Hi, who are you and what are you doing here?"),
            array("_NPC_", "Hello. My name is Colin wood, I^m the woodcutting instructor."),
            array("_NPC_", "I^m here to inform people about the woodcutting skill."),
            array("_NAME_", "Interesting. Tell me more."),
            array("_NPC_", "Woodcutting is a skill that allows players to obtain logs from trees."),
            array("_NPC_", "Players can then make bows and other items from the logs using the fletching skill."),
            array("_NPC_", "As you can see there^s plenty of trees around here."),
            array("_NPC_", "Try to cut them down for some logs!."),
            array("_NPC_", "I can see you already have an axe on you. Good luck!"),
            array("_NAME_", "Thanks!"),
        ));

        //Fisherman
        $this->dialogue(5, array(
            array("_NAME_", "Hi, what are you doing?"),
            array("_NPC_", "I^m fishing."),
            array("_NAME_", "Of course you are. Stupid question."),
            array("_NAME_", "Can you tell me where you got your fishing rod?"),
            array("_NPC_", "I bought it from a merchant. He lives in a tent north from here."),
            array("_NPC_", "If I remember correctly it cost me 100 gold pieces."),
            array("_NAME_", "Thanks for the info. I^ll leave you alone."),
            array("_NPC_", "See you later."),
        ));
    }

    public function dialogue($dialogueId, array $messages)
    {
        DB::table('dialogues')->insert([
            'id' => $dialogueId,
        ]);
        foreach ($messages as $m) {
            DB::table('dialogue_messages')->insert([
                'dialogue_id' => $dialogueId,
                'actor' => $m[$this->ACTOR],
                'text' => $m[$this->TEXT]
            ]);
        }
    }
}
