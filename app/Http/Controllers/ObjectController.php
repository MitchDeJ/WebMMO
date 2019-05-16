<?php

namespace App\Http\Controllers;

use App\AreaObject;
use App\Constants;
use App\InventorySlot;
use App\SkillAction;
use App\User;
use App\UserSkill;
use App\UserSkillAction;
use Illuminate\Http\Request;
use App\Item;
use App\Skill;
use Auth;

class ObjectController extends Controller
{
    public function interact(Request $request)
    {
        $user = Auth::user();
        $id = $request['id'];
        $item = Item::find(1);
        $skill = Skill::find(1);
        //TODO check if object is in user area

        if ($this->hasSkillAction($id)) {
            $action = $this->getSkillAction($user->id, $id);
            $action->user_id = $user->id;
            $max = $action->getUserMaxAmount($user->id);
            return view('skillaction')->with(array(
                'action' => $action,
                'item' => $item,
                'skill' => $skill,
                'object' => AreaObject::find($id),
                'max' => $max
            ));
        }

        return redirect('location');
    }


    public static function getSkillAction($userId, $id)
    {
        $inv = InventorySlot::getInstance();

        switch ($id) {

            case 1://cooking range
                return SkillAction::make(array(
                    'user_id' => $userId,
                    'skill_id' => Constants::$COOKING,
                    'xp_amount' => 20,
                    'success_chance' => 0.75,
                    'delay' => 5,
                    'req_item' => 3, //raw fish
                    'req_item_amount' => 1,
                    'product_item' => 12, //cooked fish
                    'product_item_amount' => 1
                ));

            case 2://fletching table

                $logsIntoUnstrungBow = SkillAction::make(array(
                    'user_id' => $userId,
                    'skill_id' => Constants::$CRAFTING,
                    'xp_amount' => 10,
                    'success_chance' => 1.0,
                    'delay' => 5,
                    'tool_item' => 13, //knife
                    'req_item' => 4, //logs
                    'req_item_amount' => 1,
                    'product_item' => 14, //unstrung bow
                    'product_item_amount' => 1
                ));

                $stringBows = SkillAction::make(array(
                    'user_id' => $userId,
                    'skill_id' => Constants::$CRAFTING,
                    'xp_amount' => 15,
                    'success_chance' => 1.0,
                    'delay' => 5,
                    'req_item' => 14, //unstrung bow
                    'req_item_amount' => 1,
                    'req_item_2' => 15, //bowstring
                    'req_item_2_amount' => 1,
                    'product_item' => 16, //unstrung bow
                    'product_item_amount' => 1
                ));

                $actions = array($stringBows, $logsIntoUnstrungBow);

                foreach ($actions as $a) {
                    if ($inv->hasItem($userId, $a->tool_item) && $inv->hasItem($userId, $a->req_item))
                        return $a;
                }

                return $logsIntoUnstrungBow;


            default:
                return null;

        }
    }

    public function hasSkillAction($id)
    {
        return $this->getSkillAction(1, $id) != null;
    }

}
