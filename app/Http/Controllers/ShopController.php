<?php

namespace App\Http\Controllers;

use App\InventorySlot;
use App\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Shop;

class ShopController extends Controller
{

    public function shopIndex($shopId) {
        //TODO Checks location
        $shop = Shop::find($shopId);

        if (!$shop)
            return redirect('location')->with('fail', 'Invalid shop.');


        $shopItems = $shop->getItems();
        $items = Item::find(1);
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        $gp = $inv->getItemCount($user->id, 17);
        //required for inventory
        $slots = $inv->getInventory(Auth::user()->id);

        return view('shop')->with(array(
            'shop' => $shop,
            'shopitems' => $shopItems,
            'items' => $items,
            'gp' => $gp,
            'slots' => $slots
        ));
    }

   public function buyItem(Request $request) {
       $user = Auth::user();
       $inv = InventorySlot::getInstance();
       $gp = $inv->getItemCount($user->id, 17);
       $shop = Shop::find($request['shopid']); //TODO check if this shop is in current location
       $shopitem = ShopItem::find($request['shopitemid']); //TODO check if this item is in the current shop.
       $price = $shopitem->sell_price * $request['amount'];

       if ($price > $gp) {
           return redirect('shop/'.$shop->id)->with('fail', 'You do not have enough gold to buy that many.');
       } else {
           $gp -= $price;
           $slot = $inv->getSlotOfItem($user->id, 17);
           $slot->amount = $gp;
           $slot->save();
           $inv->addItem($user->id, $shopitem->item_id, $request['amount']);
           return redirect('shop/'.$shop->id);
       }
   }
}
