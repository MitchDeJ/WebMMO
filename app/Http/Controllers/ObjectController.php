<?php

namespace App\Http\Controllers;

use App\AreaObject;
use App\Constants;
use App\InventorySlot;
use App\SkillAction;
use App\UserSkill;
use App\UserSkillAction;
use Illuminate\Http\Request;
use App\Item;
use App\Skill;
use Auth;

class ObjectController extends Controller
{
    public function interact(Request $request) {
        $user = Auth::user();
        $id = $request['id'];
        $item = Item::find(1);
        $skill = Skill::find(1);
        //TODO check if object is in user area

        if ($this->hasSkillAction($id)) {
            $action = $this->getSkillAction($id);
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


    public static function getSkillAction($id) {
        switch($id){

            case 1://cooking range
                return SkillAction::make(array(
                    'user_id' => 1,
                    'skill_id' => Constants::$COOKING,
                    'xp_amount' => 20,
                    'success_chance' => 0.75,
                    'delay' => 5,
                    'req_item' => 3, //raw fish
                    'req_item_amount' => 1,
                    'product_item' => 12, //cooked fish
                    'product_item_amount' => 1
                ));

            default:
                return null;

        }
    }

    public function hasSkillAction($id) {
        return $this->getSkillAction($id) != null;
    }

}
