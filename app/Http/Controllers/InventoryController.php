<?php

namespace App\Http\Controllers;

use App\EquipReq;
use App\InventorySlot;
use App\Item;
use App\UserEquip;
use Illuminate\Http\Request;
use Auth;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $inv = InventorySlot::getInstance();
        $slots = $inv->getInventory(Auth::user()->id);
        $items = Item::findOrFail(1);
        $equips = array();
        $eqplaceholders = array();
        foreach(UserEquip::where('user_id', Auth::user()->id)->get() as $e) {
            $equips[$e->equip_slot] = $e->item_id;
            $eqplaceholders[$e->equip_slot] = $e->getSlotPlaceholder();
        }
        return view('inventory', array(
           'slots' => $slots,
            'items' => $items,
            'equips' => $equips,
            'eqplaceholders' => $eqplaceholders
        ));
    }

    public function unequipItem(Request $request) {
        $slot = $request['slot'];
        $user = Auth::user();

        $inv = InventorySlot::getInstance();
        $freeslot = $inv->getFreeSlot($user->id);
        $equipslot = UserEquip::where('user_id', $user->id)
            ->where('equip_slot', $slot)->get()->first();
        if (!$equipslot) {
            return response()->json([
                'status' => false
            ]);
        }

        // no free slots
        if ($freeslot == null) {
            return response()->json([
                'status' => false
            ]);
        }

        if ($equipslot->item_id == null) {
            return response()->json([
                'status' => false
            ]);
        }

        $item = Item::findOrFail($equipslot->item_id);

        $targetSlot = InventorySlot::where('user_id', $user->id)
            ->where('slot', $freeslot)->get()->first();
        $equipslot = UserEquip::where('user_id', $user->id)
            ->where('equip_slot', $slot)->get()->first();
        $toGive = $equipslot->item_id;
        $equipslot->item_id = null;
        $equipslot->save();
        $targetSlot->item_id = $toGive;
        $targetSlot->save();
        return response()->json([
            'status' => true,
            'slot' => $freeslot,
            'itemIcon' => url($item->getIconPath($item->id)),
            'itemName' => $item->name,
        ]);
    }

    public function useItem(Request $request) {
        $slot = $request['slot'];
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        $item = $inv->getItemOfSlot($user->id, $slot);

        if ($item == null)
            return response()->json([]);

        $equipslot = $item->getEquipSlot($item->id);

        //equip item
        if ($equipslot != -1) {
            $ue = UserEquip::where('user_id', $user->id)
                ->where('equip_slot', $equipslot)->get()->first();
            $invslot = InventorySlot::where('user_id', $user->id)
                ->where('slot', $slot)->get()->first();
            $item = Item::findOrFail($invslot->item_id);

            //check requirements
            if (!EquipReq::check($user->id, $item->id)) {
                return response()->json([
                    'status' => 'noreqs'
                ]);
            }

            $swapItem = $ue->item_id;

            if ($swapItem != null) {
                $swapItem = Item::find($swapItem);
                $swapName = $swapItem->name;
                $swapIcon = url($swapItem->getIconPath($swapItem->id));
                $swapSlot = $invslot->slot;
            } else {
                $swapName = "";
                $swapIcon = "";
                $swapSlot = "";
            }

            $ue->equip($user, $slot);
            return response()->json([
                'status' => 'equip',
                'slot' => $equipslot,
                'equipName' => $item->name,
                'equipIcon' => url($item->getIconPath($item->id)),
                'swapName' => $swapName,
                'swapIcon' => $swapIcon,
                'swapSlot' => $swapSlot
            ]);
        }

        return response()->json([
            'status' => 'use'
        ]);
    }

    public function destroyItem(Request $request) {
        $user = Auth::user();
        $invslot = InventorySlot::where('user_id', $user->id)
            ->where('slot', $request['slot'])->get()->first();

        if (!$invslot)
            return response()->json(['status' => false]);

        $invslot->item_id = null;
        $invslot->amount = 0;
        $invslot->save();

        return response()->json(['status' => true, 'slot' => $invslot->slot]);
    }
}
