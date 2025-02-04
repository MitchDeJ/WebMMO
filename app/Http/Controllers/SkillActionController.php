<?php

namespace App\Http\Controllers;

use App\AreaObject;
use App\Func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SkillAction;
use App\UserSkillAction;
use App\InventorySlot;
use App\Skill;
use App\UserSkill;
use App\Item;


class SkillActionController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $userAction = UserSkillAction::where('user_id', $user->id)->get()->first();
        $action = SkillAction::find($userAction->skill_action_id);
        $item = Item::find(1);
        $skill = Skill::find(1);
        $results = array();
        $results['xp'] = $userAction->success_amount * $action->xp_amount;
        $results['items'] = $userAction->success_amount * $action->product_item_amount;
        $results['skill'] = $skill->getName($action->skill_id);
        $results['product_img'] = url($item->getIconPath($action->product_item));

        return view('skillactionprogress')->with(array(
            'action' => $action,
            'userAction' => $userAction,
            'item' => $item,
            'skill' => $skill,
            'results' => $results
        ));
    }

    public static function inSkillAction($userId)
    {
        $action = UserSkillAction::where('user_id', $userId)->get();
        if (count($action) > 0)
            return true;

        return false;
    }

    public function startAction(Request $request)
    {
        $user = Auth::user();
        $id = $request['id'];
        $amount = $request['amount'];
        $item = Item::find(1);

        if (!Func::validAmount($amount))
            return redirect('location')->with('fail', 'Invalid amount.');

        //TODO check if object is in user area

        $action = ObjectController::getSkillAction($user->id, $id);

        if (is_countable($action)) {
            $action = $action[$request['i']];
            if (!$action)
                return redirect('location');
        }


        //check action skill req
        $uskill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $action->skill_id)->get()->first();
        if ($uskill->getLevel() < $action->req_level) {
            return redirect('location')->with('fail', 'You need a '.Skill::find($uskill->skill_id)->name.
                ' level of '.$action->req_level.' to do that.');
        }

        $inv = InventorySlot::getInstance();

        $max = $action->getUserMaxAmount($user->id);
        if ($amount > $max)
            $amount = $max;

        $freeSlots = $inv->getFreeSlots($user->id);

        if ($action->req_item != null && !$item->isStackable($action->req_item))
            $freeSlots +=  $inv->getItemCount($user->id, $action->req_item);

        if ($action->req_item_2 != null && !$item->isStackable($action->req_item_2))
            $freeSlots +=  $inv->getItemCount($user->id, $action->req_item_2);

        if ($amount > $freeSlots)
            $amount = $freeSlots;

        //check  tool
        if ($action->tool_item != null & (!$inv->hasItem($user->id, $action->tool_item)))
            return redirect('location')->with('fail', 'You do not have the required tool with you to do that.');

        //check required items
        if ($action->req_item != null) {
            $reqCount = $amount * $action->req_item_amount;
            $count = $inv->getItemCount($user->id, $action->req_item);

            if ($reqCount > $count)
                return redirect('location')
                    ->with('fail', 'You do not have the required resources with you to make that many.');
        }
        //check secondary required item
        if ($action->req_item_2 != null) {
            $reqCount = $amount * $action->req_item_2_amount;
            $count = $inv->getItemCount($user->id, $action->req_item_2);

            if ($reqCount > $count)
                return redirect('location')
                    ->with('fail', 'You do not have the required resources with you to make that many.');
        }

        //remove required items
        if ($action->req_item != null) {
            $inv->removeItem($user->id, $action->req_item, $amount * $action->req_item_amount);
        }
        if ($action->req_item_2 != null) {
            $inv->removeItem($user->id, $action->req_item_2, $amount * $action->req_item_2_amount);
        }

        $time = $action->delay * $amount;

        $action->save();
        //determine success
        $successAmount = 0;
        $success = $action->success_chance * 100;
        for($i=0; $i<$amount; $i++) {
            $rng = rand(0, 100);
            if ($rng <= $success)
                $successAmount++;
        }

        UserSkillAction::create(array(
            'user_id' => $user->id,
            'start' => time(),
            'end' => time() + $time,
            'skill_action_id' => $action->id,
            'amount' => $amount,
            'success_amount' => $successAmount,
            'running' => true
        ));

        return redirect('location');
    }

    public function completeAction(Request $request)
    {
        $user = Auth::user();
        $userAction = UserSkillAction::where('user_id', $user->id)->get()->first();
        $action = SkillAction::find($userAction->skill_action_id);

        //not completed yet
        if ($userAction->end > time())
            return redirect('location');//send back without results

        $inv = InventorySlot::getInstance();
        //add product
        $inv->addItem($user->id, $action->product_item, $userAction->success_amount * $action->product_item_amount);
        //give xp
        $uskill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $action->skill_id)->get()->first();
        $levelUp = $uskill->addXp($userAction->success_amount * $action->xp_amount);
        //clean up
        $userAction->delete();
        $action->delete();
        $skill = Skill::find($action->skill_id);
        if ($levelUp == false)
            return redirect('location');
        else
            return redirect('location')
                ->with('levelUp', true)
                ->with('skillIcon', url($skill->getIconPath($skill->id)))
                ->with('skillName', $skill->name)
                ->with('skillLevel', $uskill->getLevel());
    }

    public function selectAction(Request $request) {
        $user = Auth::user();
        $item = Item::find(1);
        $skill = Skill::find(1);
        $obj = AreaObject::find($request['obj']);

        if (!$obj)
            return redirect('location')->with('fail', 'Invalid object.');

        $action = ObjectController::getSkillAction($user->id, $obj->id)[$request['i']];
        $action->user_id = $user->id;
        $max = $action->getUserMaxAmount($user->id);
        return view('skillaction')->with(array(
            'action' => $action,
            'item' => $item,
            'skill' => $skill,
            'object' => $obj,
            'max' => $max,
            'i' => $request['i']
        ));
    }
}
