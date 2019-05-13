<?php

use Illuminate\Database\Seeder;

class DialogueSeeder extends Seeder
{
    public $ACTOR = 0;
    public $TEXT = 1;

    public function run()
    {
        //example conversation
        $this->dialogue(1, array(
            array("_NPC_", "Hello, _NAME_. Welcome to WebMMO!"),
            array("_NPC_", "I^m _NPC_. Im here to showcase the dialogue system."),
            array("_NAME_", "Hi _NPC_."),
            array("_NPC_", "As you can see, it works quite well."),
            array("_NAME_", "That^s cool. Thanks _NPC_."),
            array("_NPC_", "No worries _NAME_, just doing my job.")
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
