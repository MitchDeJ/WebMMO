<?php

namespace App\Http\Controllers;

use App\Area;
use App\Dialogue;
use App\DialogueMessage;
use App\InventorySlot;
use App\Npc;
use App\Shop;
use App\User;
use App\Item;
use App\UserDialogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NpcController extends Controller
{
    public function interact(Request $request)
    {
        $user = Auth::user();
        $area = Area::find($user->area_id);
        $npcId = $request['id'];
        $item = Item::find(1);

        if (!$area->hasNpc($npcId)) {
            return redirect('location');
        }

        if (count(Npc::where('id', $npcId)->get()) == 0)
            return redirect('location');

        $npc = Npc::find($npcId);

        //starting dialogue
        if ($this->getDialogue($npcId, $user->id) != -1) {
            $dId = $this->getDialogue($npcId, $user->id);
            $msgs = DialogueMessage::where('dialogue_id', $dId)->get();
            $dialogue = array();
            foreach ($msgs as $msg) {
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

        //opening shops
        if ($this->getShop($npcId) != -1) {
            $shopId = $this->getShop($npcId);
            $shop = Shop::find($shopId);
            return redirect('shop/' . $shopId);
        }
    }

    public function endDialogue(Request $request)
    {
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        $d = $user->getDialogue();

        if ($d == -1)
            return response('OK', 200)
                ->header('Content-Type', 'text/plain');

        switch ($d) {

            case 1://mining instructor gives a pickaxe
                $inv->addItem($user->id, 20, 1);
                break;

            case 3://wc instructor gives an axe
                $inv->addItem($user->id, 1, 1);
                break;
        }

        UserDialogue::where('user_id', $user->id)->get()
            ->first()->delete();
        return response('OK', 200)
            ->header('Content-Type', 'text/plain');
    }

    public static function getOption($npcId)
    {
        if (NpcController::getDialogue($npcId, 1) != -1)
            return "Talk";

        if (NpcController::getShop($npcId) != -1)
            return "Trade";

        return "Option";
    }


    public static function getDialogue($npcId, $userId)
    {
        $inv = InventorySlot::getInstance();

        switch ($npcId) {

            case 2://Mining instructor
                if (!$inv->hasItem($userId, 20, 1))
                    return 1;//give pickaxe
                else
                    return 2; //only inform
            break;

            case 3://Woodcutting instructor
                if (!$inv->hasItem($userId, 1, 1))
                    return 3;//give axe
                else
                    return 4; //only inform
                break;

            case 5://fisherman
                return 5;

            default:
                return -1;
        }
    }

    public static function getShop($npcId)
    {
        switch ($npcId) {
            case 1://bob
                return 2;//adventurers shop
            case 4:
                return 1; //merchant wares

            default:
                return -1;
        }
    }
}
