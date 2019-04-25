<?php

namespace App\Http\Controllers;

use App\InventorySlot;
use App\Item;
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
        return view('inventory', array(
           'slots' => $slots,
            'items' => $items
        ));
    }
}
