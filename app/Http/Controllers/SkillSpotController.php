<?php

namespace App\Http\Controllers;

use App\Constants;
use App\InventorySlot;
use App\Item;
use App\Cooldown;
use App\SpotRequirement;
use App\UserSkill;
use App\Skill;
use App\SkillSpot;
use Illuminate\Http\Request;
use Auth;

class SkillSpotController extends Controller
{
    public function useSpot(Request $request) {
        $id = $request['id'];
        $count = SkillSpot::where('id', $id)->count();
        $skills = Skill::findOrFail(1);

        if ($count == 0) { //invalid ID, return to location page
            return redirect('location')->with('fail', 'Invalid skilling spot.');
        }

        $spot = SkillSpot::find($id);
        $user = Auth::user();

        if ($spot->area_id != Auth::user()->area_id) { //this skillspot is not in your current location, return.
            return redirect('location')->with('fail', 'Invalid skilling spot.');
        }

        //check cooldown
        if (Cooldown::check(Auth::user()->id, Constants::$COOLDOWN_SKILLING) != false) {
            return redirect('location')->with('fail', 'This action is not available yet.');
        }

        //check skill requirements
        $reqs = SpotRequirement::where('spot_id', $spot->id)->get();
        foreach ($reqs as $req) {
           $skill = UserSkill::where('user_id', $user->id)->where('skill_id', $req->skill_id)->get()->first();
            if ($skill->getLevel() < $req->requirement) {; //does not meet the requirements
                return redirect('location')->with('fail', 'You need a '.$skills->getName($skill->skill_id).' level of '.$req->requirement.' to do that.');
            }
        }

        //check tool requirement
        if (!$this->checkTool($user->id, $spot->skill_id)) {
            return redirect('location')->with('fail', 'You do not have the correct tool with you to do that.'); //does not have the correct tool
        }

        $userSkill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $spot->skill_id)->get()->first();

        //get item to give
        $item = Item::find($spot->item_id);

        //get amount to give
        $amount = rand($spot->amount_min, $spot->amount_max);

        //give exp
        $userSkill->addXp($amount * $spot->xp_amount);

        //give item
        $inv = InventorySlot::getInstance();
        $inv->addItem($user->id, $item->id, $amount);

        //add cooldown
        Cooldown::create(
            [
                'user_id' => Auth::user()->id,
                'type' => Constants::$COOLDOWN_SKILLING,
                'end' => (time() + $spot->cooldown)
            ]
        );
        return redirect('location')->with('success', 'You have successfully gathered '.$amount.'x '.$item->name.' and gained '.($amount * $spot->xp_amount).'xp.');
    }

    function checkTool($userId, $skillId) {

        $AXE_IDS = array(1);
        $ROD_IDS = array(2);

        $inv = InventorySlot::getInstance();
        $slots = $inv->getInventory($userId);

        $toCheck = array();

        if ($skillId == Constants::$WOODCUTTING)
            $toCheck = $AXE_IDS;
        if ($skillId == Constants::$FISHING)
            $toCheck = $ROD_IDS;

        foreach($slots as $slot) {
            if (in_array($slot->item_id, $toCheck)) {
                return true;
            }
        }
        return false;
    }
}
