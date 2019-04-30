<?php

namespace App\Http\Controllers;

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
        foreach(UserEquip::where('user_id', Auth::user()->id)->get() as $e) {
            $equips[$e->equip_slot] = $e->item_id;
        }
        return view('inventory', array(
           'slots' => $slots,
            'items' => $items,
            'equips' => $equips
        ));
    }
}
