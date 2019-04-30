<?php

namespace App\Http\Controllers;

use App\InventorySlot;
use App\Item;
use App\UserEquip;
use Illuminate\Http\Request;
use Auth;

class ItemController extends Controller
{
    public function useItem($slot) {
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        $item = $inv->getItemOfSlot($user->id, $slot);

        if ($item == null)
            return redirect('inventory')->with('neutral', 'you clicked slot '.$slot.'.');

        $equipslot = $item->getEquipSlot($item->id);

        //equip item
        if ($equipslot != -1) {
            $ue = UserEquip::where('user_id', $user->id)
                ->where('equip_slot', $equipslot)->get()->first();
            $ue->equip($user, $slot);
            return redirect('inventory')->with('neutral', 'you have equipped your '.$item->name);
        }

        return redirect('inventory')->with('neutral', 'you clicked slot '.$slot.'. Item: '.$item->name);
    }

    public function unequipItem($slot) {
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        $freeslot = $inv->getFreeSlot($user->id);
        $equipslot = UserEquip::where('user_id', $user->id)
            ->where('equip_slot', $slot)->get()->first();

        // no free slots
        if ($freeslot == null)
            return redirect('inventory')->with('fail', 'You do not have enough free slots in your inventory to do that.');

        if ($equipslot->item_id == null)
            return redirect('inventory');

        $item = Item::findOrFail($equipslot->item_id);

        $inv->addItem($user->id, $equipslot->item_id, 1);
        $equipslot->item_id = null;
        $equipslot->save();
        return redirect('inventory')->with('neutral', 'you have unequipped your '.$item->name);
    }
}
