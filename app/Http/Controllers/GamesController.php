<?php

namespace App\Http\Controllers;

use App\Coinflip;
use App\Func;
use App\Item;
use Illuminate\Http\Request;
use Auth;
use App\InventorySlot;
use App\Area;

class GamesController extends Controller
{
    public function coinflipIndex() {
        $user = Auth::user();
        $loc = Area::find($user->area_id);
        if (!$loc->hasCoinflipObject())
            return redirect('location')->with('fail', 'There is no coinflip table in this area.');

        return view('coinflips', array(
            'coinflips' => Coinflip::all(),
            'myflips' => Coinflip::where('user_id', Auth::user()->id)->get(),
            'items' => Item::find(1)
        ));
    }

    public function newCoinflip(Request $request) {
        $user = Auth::user();
        $flips = Coinflip::where('user_id', Auth::user()->id)->get();
        if (count($flips) == 2) {
            return redirect("coinflip")->with('fail', 'You already have the maximum of 2 active coinflip games.');
        }

        $gp = $user->getGP();

        $bet = $request['bet'];

        if ($bet < 1)
            return redirect("coinflip")->with('fail', 'Invalid bet.');

        if (!Func::validAmount($bet))
            return redirect("coinflip")->with('fail', 'Invalid bet.');

        if ($bet > $gp)
            return redirect("coinflip")->with('fail', "You don't have that much gp.");

        $inv = InventorySlot::getInstance();
        $inv->removeItem($user->id, 17, $bet);

        Coinflip::create([
            'user_id' => $user->id,
            'bet' => $bet
        ]);
        return redirect("coinflip")->with('success', 'Coinflip game created.');
    }

    public function removeCoinflip(Request $request) {
        $user = Auth::user();

        $id = $request['id'];
        $c = Coinflip::where('id', $id);

        if ($c) {
            $c = $c->get()->first();
        } else {
            return redirect("coinflip")->with('fail', 'Invalid game.');
        }

        if ($c->user_id == $user->id) {
            $inv = InventorySlot::getInstance();
            $inv->addItem($user->id, 17, $c->bet);
            $c->delete();
            return redirect("coinflip")->with('success', 'Coinflip game removed.');
        } else {
            return redirect("coinflip")->with('fail', 'Invalid game.');
        }
    }

    public function playCoinflip(Request $request) {
        $user = Auth::user();
        $gp = $user->getGP();

        $id = $request['id'];
        $c = Coinflip::where('id', $id);

        if ($c) {
            $c = $c->get()->first();
        } else {
            return redirect("coinflip")->with('fail', 'Invalid game.');
        }

        if ($c->user_id == $user->id) {
            return redirect("coinflip")->with('fail', 'You can not play your own game.');
        } else {

            if ($gp < $c->bet)
                return redirect("coinflip")->with('fail', 'You do not have enough gp to play this game.');

            $inv = InventorySlot::getInstance();
            $inv->removeItem($user->id, 17, $c->bet);

            $rng = rand(1, 100);

            if ($rng >= 1 && $rng <= 50) { //user wins
                $inv->addItem($user->id, 17, $c->bet * 2);
                $win = true;
            } else if ($rng >= 51 && $rng <= 100) { //other wins
                $inv->addItem($c->user_id, 17, $c->bet * 2);
                $win = false;
            }


            $c->delete();

            if($win)
                return redirect('coinflip')->with('success', 'You flip a coin and it turns out to be tails. You win!');
            else
                return redirect('coinflip')->with('fail', 'You flip a coin and it turns out to be heads. You lose!');
        }
    }
}
