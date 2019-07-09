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
        $obj = AreaObject::find($id);

        if (!$obj)
            return redirect('location');

        $item = Item::find(1);
        $skill = Skill::find(1);
        //TODO check if object is in user area

        if ($this->hasSkillAction($id)) {
            $action = $this->getSkillAction($user->id, $id);

            if (count($action) > 1) {//show skill action menu
                return view('skillactionmenu')->with(array(
                    'object' => AreaObject::find($id),
                    'item' => $item,
                    'skill' => $skill,
                    'actions' => $action
                ));
            }

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

        if (ObjectController::opensMarket($id)) {
            return redirect('market');
        }

        if (ObjectController::opensBank($id)) {
            return redirect('bank');
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

                $actions = array($logsIntoUnstrungBow, $stringBows);

                return $actions;


            default:
                return null;

        }
    }

    public static function hasSkillAction($id)
    {
        return ObjectController::getSkillAction(1, $id) != null;
    }

    public static function opensMarket($id) {
        switch ($id) {
            case 3: //Trading Post
                return true;
        }
    }

    public static function opensBank($id) {
        switch ($id) {
            case 4: //Bank chest
                return true;
        }
    }

}
