<?php

namespace App\Http\Controllers;

use App\Area;
use App\DialogueMessage;
use App\InventorySlot;
use App\Npc;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NpcController extends Controller
{
    public function interact(Request $request) {
        $user = Auth::user();
        $area = Area::find($user->area_id);
        $npcId = $request['id'];

        if (!$area->hasNpc($npcId)) {
            return redirect('location');
        }

        if (count(Npc::where('id', $npcId)->get()) == 0)
            return redirect('location');

        $npc = Npc::find($npcId);

        //starting dialogue
        if ($this->getDialogue($npcId) != -1) {
            $dId = $this->getDialogue($npcId);
            $msgs = DialogueMessage::where('dialogue_id', $dId)->get();
            $dialogue = array();
            foreach($msgs as $msg) {
                $toAdd = array();
                $toAdd['actor'] = $msg->actor;
                $toAdd['text'] = $msg->text;
                array_push($dialogue, $toAdd);
            }
            $user->setDialogue($dId);
            return view('dialogue')->with(array(
                'dialogue' => $dialogue,
                'user' => $user,
                'npc' => $npc,
                'dId' => $dId
            ));
        }
    }

    public function endDialogue(Request $request) {
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        switch($user->getDialogue()) {

            case 1://default dialogue gives an apple.
                $inv->addItem($user->id, 11, 1);
                break;
        }


        return response('OK', 200)
            ->header('Content-Type', 'text/plain');
    }


    public function getDialogue($npcId) {
        switch($npcId) {
            case 1://bob
                return 1;//example dialogue
            case 2://arran
                return 1;//example dialogue
        }
    }
}
