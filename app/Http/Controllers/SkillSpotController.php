<?php

namespace App\Http\Controllers;

use App\InventorySlot;
use App\Item;
use App\Cooldown;
use App\SpotRequirement;
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

        //check skill requirements
        $reqs = SpotRequirement::where('spot_id', $spot->id)->get();
        foreach ($reqs as $req) {
           $skill = UserSkill::where('user_id', $user->id)->where('skill_id', $req->skill_id)->get()->first();
            if ($skill->getLevel() < $req->requirement) {
                return redirect('location'); //does not meet the requirements //TODO add message
            }
        }

        //check tool requirement
        if (!$this->checkTool($user->id, $spot->skill_id)) {
            return redirect('location'); //does not have the correct tool //TODO add message
        }

        $userSkill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $spot->skill_id)->get()->first();

        //get item to give
        $item = Item::find($spot->item_id);

        //execute action
        $userSkill->addXp($spot->xp_amount);

        //give item
        $inv = InventorySlot::getInstance();
        $inv->addItem($user->id, $item->id, 1); //TODO varying amount (change the 1)

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

    function checkTool($userId, $skillId) {

        $AXE_IDS = array(1);
        $ROD_IDS = array(2);

        $inv = InventorySlot::getInstance();
        $slots = $inv->getInventory($userId);

        $toCheck = array();

        if ($skillId == 1) //woodcutting
            $toCheck = $AXE_IDS;
        if ($skillId == 2) //fishing
            $toCheck = $ROD_IDS;

        foreach($slots as $slot) {
            if (in_array($slot->item_id, $toCheck)) {
                return true;
            }
        }
        return false;
    }
}
