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
            return response()->json([
                'status' => false,
                'statustext' => 'Invalid skilling spot.'
            ]);
        }

        $spot = SkillSpot::find($id);
        $user = Auth::user();

        if ($spot->area_id != Auth::user()->area_id) { //this skillspot is not in your current location, return.
            return response()->json([
                'status' => false,
                'statustext' => 'Invalid skilling spot.'
            ]);
        }

        //check cooldown
        if (Cooldown::check(Auth::user()->id, Constants::$COOLDOWN_SKILLING) != false) {
            return response()->json([
                'status' => false,
                'statustext' => 'That action is not available yet.'
            ]);
        }


        //check skill requirements
        $reqs = SpotRequirement::where('spot_id', $spot->id)->get();
        foreach ($reqs as $req) {
           $skill = UserSkill::where('user_id', $user->id)->where('skill_id', $req->skill_id)->get()->first();
            if ($skill->getLevel() < $req->requirement) { //does not meet the requirements
                return response()->json([
                    'status' => false,
                    'statustext' => 'You need a '.$skills->getName($skill->skill_id).' level of '.$req->requirement.' to do that.'
                ]);
            }
        }

        //check tool requirement
        if (!$this->checkTool($user->id, $spot->skill_id)) {
            return response()->json([
                'status' => false,
                'statustext' => 'You do not have the correct tool with you to do that.'
            ]);
        }

        //add cooldown
        Cooldown::create(
            [
                'user_id' => Auth::user()->id,
                'type' => Constants::$COOLDOWN_SKILLING,
                'end' => (time() + $spot->cooldown)
            ]
        );

        $userSkill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $spot->skill_id)->get()->first();

        //get item to give
        $item = Item::find($spot->item_id);

        //get amount to give
        $amount = rand($spot->amount_min, $spot->amount_max);

        //give exp
        $levelUp = $userSkill->addXp($amount * $spot->xp_amount);

        //give item
        $inv = InventorySlot::getInstance();
        $inv->addItem($user->id, $item->id, $amount);


        $skill = Skill::find($spot->skill_id);

        if ($levelUp == true)
        return response()->json([
            'status' => true,
            'statustext' => 'You have successfully gathered <b>'.$amount.'x '.$item->name.'</b> and gained <b>'
                .($amount * $spot->xp_amount).' '.$skill->name.' xp.</b>',
            'cooldown' => $spot->cooldown,
            'levelUp' => $levelUp,
            'skillName' => $skill->name,
            'skillIcon' => url($skill->getIconPath($skill->id)),
            'skillLevel' => $userSkill->getLevel()
        ]);
        else
            return response()->json([
                'status' => true,
                'statustext' => 'You have successfully gathered <b>'.$amount.'x '.$item->name.'</b> and gained <b>'
                    .($amount * $spot->xp_amount).' '.$skill->name.' xp.</b>',
                'cooldown' => $spot->cooldown,
                'levelUp' => $levelUp,
            ]);
    }

    function checkTool($userId, $skillId) {

        $AXE_IDS = array(1);
        $ROD_IDS = array(2);
        $PICK_IDS = array(20);

        $inv = InventorySlot::getInstance();
        $slots = $inv->getInventory($userId);

        $toCheck = array();

        if ($skillId == Constants::$WOODCUTTING)
            $toCheck = $AXE_IDS;
        if ($skillId == Constants::$FISHING)
            $toCheck = $ROD_IDS;
        if ($skillId == Constants::$MINING)
            $toCheck = $PICK_IDS;

        foreach($slots as $slot) {
            if (in_array($slot->item_id, $toCheck)) {
                return true;
            }
        }
        return false;
    }
}
