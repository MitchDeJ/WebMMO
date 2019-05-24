<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Func;
use App\MarketListing;
use Illuminate\Http\Request;
use App\Item;
use App\User;
use App\InventorySlot;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $item = Item::find(1);
        $inv = InventorySlot::getInstance();
        $gp = $inv->getItemCount($user->id, 17);
        $listings = $this->removeCompleted(MarketListing::where('user_id', '!=', $user->id)->get()->reverse()->take(10));

        return view('market')->with([
            'listings' => $listings,
            'userlistings' => MarketListing::where('user_id', $user->id)->get(),
            'item' => $item,
            'gp' => $gp
        ]);
    }

    public function newListingIndex()
    {
        $user = Auth::user();
        $inv = InventorySlot::getInstance();
        $slots = $inv->getInventory($user->id);
        $item = Item::find(1);

        $added = array();
        $sellables = array();
        foreach ($slots as $s) {
            if ($item->isMarketable($s->item_id) && !in_array($item->getName($s->item_id), $added)) {
                $sellables[$s->slot]['itemId'] = $s->item_id;
                $sellables[$s->slot]['itemName'] = $item->getName($s->item_id);
                array_push($added, $item->getName($s->item_id));
            }
        }

        $counts = array();
        foreach($sellables as $s) {
            $counts[$s['itemId']] = $inv->getItemCount($user->id, $s['itemId']);
        }

        return view('newlisting')->with([
            'sellables' => $sellables,
            'counts' => $counts
        ]);
    }

    public function submitListing(Request $request) {
        $amount = $request['amount'];
        $itemId = $request['itemselect'];
        $eaPrice = $request['price'];
        $user = Auth::user();

        $item = Item::find($itemId);

        if (!$item)
            return redirect('newlisting');

        if (!Func::validAmount($amount))
            return redirect('newlisting');

        if (!Func::validAmount($eaPrice))
            return redirect('newlisting');

        if (!$item->isMarketable($itemId))
            return redirect('newlisting');

        if (count(MarketListing::where('user_id', $user->id)) >= Constants::$MAX_LISTINGS)
            return redirect('market')->with('fail', 'You already have the maximum amount of market listings.');

        $inv = InventorySlot::getInstance();

        if ($inv->getItemCount($user->id, $itemId) < $amount) {
            return redirect('newlisting')->with('fail', 'You do not have that many.');
        }

        $inv->removeItem($user->id, $itemId, $amount);

        MarketListing::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'amount' => $amount,
            'amount_sold' => 0,
            'amount_collected' => 0,
            'price' => $eaPrice
        ]);

        return redirect('market');
    }

    public function collectListing(Request $request)
    {
        $user = Auth::user();
        $id = $request['id'];
        $listing = MarketListing::find($id);

        if (!$listing)
            return redirect('market');

        if ($listing->user_id != $user->id)
            return redirect('market');

        $toCollect = $listing->amount_sold - $listing->amount_collected;

        if ($toCollect <= 0)
            return redirect('market');

        $inv = InventorySlot::getInstance();

        if ($inv->getFreeSlots($user->id) < 1 && !$inv->hasItem($user->id, 17)) { //we have no space for coins
            return redirect('market')->with('fail', "You don't have enough space in your inventory to do that.");
        }

        $listing->increment('amount_collected', $toCollect);
        $inv->addItem($user->id, 17, $toCollect * $listing->price);
        if ($listing->amount_collected == $listing->amount)
            $listing->delete();

        return redirect('market');
    }

    public function cancelListing(Request $request)
    {
        $user = Auth::user();
        $id = $request['id'];
        $listing = MarketListing::find($id);
        $item = Item::find(1);

        if (!$listing)
            return redirect('market');

        if ($listing->user_id != $user->id)
            return redirect('market');

        $inv = InventorySlot::getInstance();
        $toCollect = $listing->amount - $listing->amount_sold;

        if ($item->isStackable($listing->item_id)) {
            if ($inv->getFreeSlots($user->id) < 1 && !$inv->hasItem($user->id, $listing->item_id)) { //we have no space
                return redirect('market')->with('fail', "You don't have enough space in your inventory to do that.");
            }
        } else {
            if ($inv->getFreeSlots($user->id) < $toCollect) {
                return redirect('market')->with('fail', "You don't have enough space in your inventory to do that.");
            }
        }

        $itemToGive = $listing->item_id;
        $listing->delete();
        $inv->addItem($user->id, $itemToGive, $toCollect);

        return redirect('market');
    }

    public function buyListing(Request $request)
    {
        $user = Auth::user();
        $id = $request['id'];
        $wantsToBuy = $request['amount'];
        $listing = MarketListing::find($id);
        $item = Item::find(1);

        if (!Func::validAmount($wantsToBuy))
            return redirect('market')->with('fail', 'Invalid amount');

        if (!$listing)
            return redirect('market');

        if ($wantsToBuy > $listing->amount)
            $wantsToBuy = $listing->amount;

        $price = ($wantsToBuy * $listing->price);

        $inv = InventorySlot::getInstance();

        $gp = $inv->getItemCount($user->id, 17);

        if ($gp < $price) {
            return redirect('market')->with('fail', 'You do not have enough gold to buy that many.');
        }

        if ($item->isStackable($listing->item_id)) {
            if ($inv->getFreeSlots($user->id) < 1 && !$inv->hasItem($user->id, $listing->item_id)) { //we have no space
                return redirect('market')->with('fail', "You don't have enough space in your inventory to do that.");
            }
        } else {
            if ($inv->getFreeSlots($user->id) < $wantsToBuy) {
                return redirect('market')->with('fail', "You don't have enough space in your inventory to do that.");
            }
        }

        $listing->increment('amount_sold', $wantsToBuy);
        $inv->removeItem($user->id, 17, $price);
        $inv->addItem($user->id, $listing->item_id, $wantsToBuy);
        return redirect('market');
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $item = Item::find(1);
        $inv = InventorySlot::getInstance();
        $gp = $inv->getItemCount($user->id, 17);
        $option = $request['searchoption'];
        $query = strtolower($request['query']);

        if ($option == 'item') {
            $queryListings = array();
            $listings = $this->removeCompleted(MarketListing::where('user_id', '!=', $user->id)->get()->reverse());
            foreach ($listings as $listing) {
                if (strpos(strtolower($item->getName($listing->item_id)), $query) !== false)
                    array_push($queryListings, $listing);
            }
        } else if ($option == 'seller') {
            $listings = MarketListing::where('user_id', '!=', $user->id)->get();
            $listings = $this->removeCompleted($listings);
            $users = User::where('name', 'LIKE', '%' . $query . '%')->get();
            $ids = array();
            foreach ($users as $u) {
                array_push($ids, $u->id);
            }
            $queryListings = $listings->whereIn('user_id', $ids)->reverse();
        } else {
            return redirect('market');
        }

        return view('market')->with([
            'listings' => $queryListings,
            'userlistings' => MarketListing::where('user_id', $user->id)->get(),
            'item' => $item,
            'gp' => $gp,
            'query' => $query,
            'option' => $option
        ]);
    }

    public function removeCompleted($collection)
    {
        $collection = $collection->keyBy('id');
        $toRemove = array();
        foreach ($collection as $i) {
            if ($i->amount - $i->amount_sold == 0)
                array_push($toRemove, $i->id);
        }
        foreach ($toRemove as $r) {
            $collection->pull($r);
        }
        return $collection;
    }
}
