<?php

namespace App\Http\Controllers;

use App\EquipReq;
use App\InventorySlot;
use App\Item;
use App\ItemStats;
use App\UserEquip;
use App\Skill;
use Illuminate\Http\Request;
use Auth;

class ItemController extends Controller
{

    public function getInfo(Request $request) {
        $slot = $request['slot'];
        $user = Auth::user();
        $inv = InventorySlot::getInstance();

        $infos = array();
        $options = array();
        $stats = array();
        $reqText = array();

        $item = $inv->getItemOfSlot($user->id, $slot);

        if ($item == null)
            return response()->json(['options'=> $options]); //return empty options array with invalid items

        $equipslot = $item->getEquipSlot($item->id);

        //equip item
        if ($equipslot != -1) {

            $equip = array('Equip', url('useitem/'.$slot));
            array_push($options, $equip);

            //add item stats to response
            $itemstats = ItemStats::where('item_id', $item->id)->get()->first();
            array_push($stats, $itemstats->melee, $itemstats->melee_defence, $itemstats->ranged,
                $itemstats->ranged_defence, $itemstats->magic, $itemstats->magic_defence);

            //add reqs to response
            $reqs = EquipReq::where('item_id', $item->id)->get();
            if ($reqs) {
                $i=0;
                foreach($reqs as $req) {
                    $skillName = Skill::find($req->skill_id)->name;
                    $reqText[$i] = ''.$req->level.' '.$skillName;
                    $i++;
                }
            }

        } else {
            $use = array ('Use', url('useitem/'.$slot));
            array_push($options, $use);
        }

        //if item is food, add heal amount
        $heal = $item->getHealAmount($item->id);

        //add 'destroy option to every item
        $destroy = array('Destroy', url('destroyitem/'.$slot));
        array_push($options, $destroy);

        //add item info to response
        array_push($infos, url($item->getIconPath($item->id)), $item->name, $item->description);

        //add amount to response if stackable
        $amount = "";
        if ($item->isStackable($item->id))
            $amount = ' ('.InventorySlot::where('user_id', $user->id)
                ->where('slot', $slot)->get()->first()->amount.')';

        return response()->json(['options'=> $options, 'infos' => $infos,
            'stats' => $stats, 'amount' => $amount, 'heal'=>$heal, 'reqs'=>$reqText]);
    }


    public function swapSlot(Request $request)
    {
        $og = $request['og'];
        $new = $request['new'];
        $user = Auth::user();
        $ogslot = InventorySlot::where('user_id', $user->id)
            ->where('slot', $og)->get()->first();
        $newslot = InventorySlot::where('user_id', $user->id)
            ->where('slot', $new)->get()->first();

        $ogitem = Item::find($ogslot->item_id);
        $ogamount = $ogslot->amount;
        $newitem = Item::find($newslot->item_id);
        $newamount = $newslot->amount;

        if ($newitem == null) {
            $ogslot->item_id = null;
            $ogslot->amount = 0;
        } else {
            $ogslot->item_id = $newitem->id;
            $ogslot->amount = $newamount;
        }

        if ($ogitem == null) {
            $newslot->item_id = null;
            $newslot->amount = 0;
        } else {
            $newslot->item_id = $ogitem->id;
            $newslot->amount = $ogamount;
        }

        $ogslot->save();
        $newslot->save();
        return response()->json([]);
    }
}
