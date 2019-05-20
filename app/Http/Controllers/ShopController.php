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
        $shop = Shop::find($shopId);

        if (!$shop)
            return redirect('location')->with('fail', 'Invalid shop.');

        $user = Auth::user();

        if (!$shop->isInArea($user->area_id))
            return redirect('location')->with('fail', 'Invalid shop.');

        $shopItems = $shop->getItems();
        $items = Item::find(1);
        $inv = InventorySlot::getInstance();
        $gp = $inv->getItemCount($user->id, 17);
        //required for inventory
        $slots = $inv->getInventory(Auth::user()->id);
        $canSell = array();
        $added = array();
        foreach($slots as $slot) {
            foreach($shopItems as $si) {
                if ($slot->item_id == $si->item_id) {  //user has item which is sold in the shop
                    if (!in_array($si->item_id, $added)) { //if this items isnt already added
                        array_push($canSell, array($si, $inv->getItemCount($user->id, $si->item_id)));
                        array_push($added, $si->item_id);
                    }
                }
            }
        }
        return view('shop')->with(array(
            'shop' => $shop,
            'shopitems' => $shopItems,
            'items' => $items,
            'gp' => $gp,
            'canSell' => $canSell
        ));
    }

   public function buyItem(Request $request) {
       $user = Auth::user();
       $inv = InventorySlot::getInstance();
       $gp = $inv->getItemCount($user->id, 17);
       $shop = Shop::find($request['shopid']);

       if (!$shop)
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid shop.');

       if (!$shop->isInArea($user->area_id))
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid shop.');

       $shopitem = ShopItem::find($request['shopitemid']);

       if (!$shopitem)
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid item.');

       $price = $shopitem->sell_price * $request['amount'];

       if (!$shopitem->isInShop($shop->id))
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid item.');

       if ($price > $gp) {
           return redirect('shop/'.$shop->id)->with('fail', 'You do not have enough gold to buy that many.');
       } else {
           $inv->removeItem($user->id, 17, $price);
           $inv->addItem($user->id, $shopitem->item_id, $request['amount']);
           return redirect('shop/'.$shop->id);
       }
   }

   public function sellItem(Request $request) {
       $itemId = $request['shopsellitemid'];
       $item = Item::find($itemId);
       $shop = Shop::find($request['shopid']);
       $user = Auth::user();

       if (!$shop)
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid shop.');

       if (!$shop->isInArea($user->area_id))
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid shop.');

       if (!$item)
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid item.');

       if (!$shop->wantsItem($item->id))
           return redirect('shop/'.$shop->id)->with('fail', 'Invalid item.');

       $sellAmount = $request['sellamount'];
       $inv = InventorySlot::getInstance();
       $count = $inv->getItemCount($user->id, $itemId);
       $price = ShopItem::where('item_id', $item->id)
           ->where('shop_id', $shop->id)->get()->first()->buy_price;
       $reward = $price * $sellAmount;
       if ($count < $sellAmount) {
           return redirect('shop/' . $shop->id)->with('fail', 'You do not have items to sell that many.');
       } else {
           $inv->addItem($user->id, 17, $reward);
           $inv->removeItem($user->id, $item->id, $sellAmount);
           return redirect('shop/'.$shop->id);
       }
   }
}
