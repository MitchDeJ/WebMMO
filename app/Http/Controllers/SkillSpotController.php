<?php

namespace App\Http\Controllers;

use App\Item;
use App\Cooldown;
use App\UserSkill;
use App\SkillSpot;
use Illuminate\Http\Request;
use Auth;

class SkillSpotController extends Controller
{
    public function useSpot(Request $request) {
        $id = $request['id'];
        $count = SkillSpot::where('id', $id)->count();

        if ($count == 0) { //invalid ID, return to location page TODO add a message
            return redirect('location');
        }

        $spot = SkillSpot::find($id);
        $user = Auth::user();

        if ($spot->area_id != Auth::user()->area_id) { //this skillspot is not in your current location, return. //TODO add message
            return redirect('location');
        }

        //check cooldown //TODO add message
        if (Cooldown::check(Auth::user()->id, 1) != false) {
            return redirect('location');
        }

        //get skill row
        $userSkill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $spot->skill_id)->get()->first();
        //get item to give
        //$item = Item::find($spot->item_id);

        //execute action
        $userSkill->addXp($spot->xp_amount);
        //TODO give $item
        //add cooldown
        Cooldown::create(
            [
                'user_id' => Auth::user()->id,
                'type' => 1,
                'end' => (time() + $spot->cooldown)
            ]
        );
        return redirect('location');
    }
}
