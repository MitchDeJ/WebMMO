<?php

namespace App\Http\Controllers;

use App\BankSlot;
use Illuminate\Http\Request;
use App\InventorySlot;
use Auth;
use App\Area;
use App\Item;
use App\UserEquip;

class BankController extends Controller
{
    public function index() {
        $user = Auth::user();

        $loc = Area::find($user->area_id);
        if (!$loc->hasMarketObject())
            return redirect('location')->with('fail', 'There is no bank in this area.');


        $inv = InventorySlot::getInstance();
        $slots = $inv->getInventory(Auth::user()->id);
        $bank = BankSlot::getInstance();
        $bankslots = $bank->getBank(Auth::user()->id);
        $items = Item::findOrFail(1);
        $equips = array();
        $eqplaceholders = array();
        foreach(UserEquip::where('user_id', Auth::user()->id)->get() as $e) {
            $equips[$e->equip_slot] = $e->item_id;
            $eqplaceholders[$e->equip_slot] = $e->getSlotPlaceholder();
        }
        return view('bank', array(
            'slots' => $slots,
            'bankslots' => $bankslots,
            'items' => $items,
            'equips' => $equips,
            'eqplaceholders' => $eqplaceholders
        ));
    }
}
