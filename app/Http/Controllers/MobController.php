<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Item;
use App\Jobs\ApplyMobKill;
use App\Mob;
use App\MobSpawn;
use App\UserSkill;
use App\MobFight;
use App\Loot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Combat;

class MobController extends Controller
{

    //show the fight page
    public function fightPageIndex() {
        $user = Auth::user();
        $fight = MobFight::where('user_id', $user->id)->get();
        if (!MobController::inMobFight($user->id))
            return redirect('location');
        else
            $fight = $fight->first();

        $hpskill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', Constants::$HP)->get()->first();

        $hp = $fight->user_hp;
        $maxhp = $hpskill->getLevel();
        $kills = $fight->kills;
        $mob = Mob::find($fight->mob_id);
        $lastupdate = $fight->last_update;
        $loot = Loot::where('user_id', $user->id)
            ->where('mob_fight_id', $fight->id)->get();
        $item = Item::find(1);

        return view('mobfight', array(
            'hp' => $hp,
            'maxhp' => $maxhp,
            'kills' => $kills,
            'mob' => $mob,
            'lastupdate' => $lastupdate,
            'loot' => $loot,
            'item' => $item
        ));
    }

    public function startMobFight(Request $request) {
        $user = Auth::user();
        $mobId = $request['id'];
        $mob = Mob::find($mobId);

        //if that mob is not in your area
        if (count(MobSpawn::where('area_id', $user->area_id)
        ->where('mob_id', $mobId)->get()) <= 0) {
            return redirect('location')->with('fail', 'Invalid mob');
        }

        //if you are already in a fight
        if (count(MobFight::where('user_id', $user->id)->get()) > 0) {
            return redirect('location')->with('fail', 'You are already fighting a mob!');
        }

        $this->createMobFight($user->id, $mobId);

        return redirect('location');
    }

    function createMobFight($userId, $mobId) {
        $hp = UserSkill::where('user_id', $userId)->where('skill_id', Constants::$HP)->get()->first()->getLevel();
        $mob = Mob::find($mobId);
        DB::table('mob_fights')->insert([
            'user_id' => $userId,
            'mob_id' => $mobId,
            'kills' => 0,
            'user_hp' => $hp,
            'damage_stack' => 0.0,
            'start' => time()+2,
            'last_update' => time()+2,
            'running' => true
        ]);

        //queue job
        $timeToKill = Combat::getTimeToKill($userId, $mobId);
        ApplyMobKill::dispatch($userId, $mobId)
            ->delay(now()->addSeconds($timeToKill)->addSeconds($mob->respawn)->subMillis(Constants::$JOB_PROCESS_DELAY));
    }

    public static function inMobFight($userId) {
        $fight = MobFight::where('user_id', $userId)->get();
        if (count($fight) > 0)
            return true;

        return false;
    }

    public static function mobFightRunning($userId) {
        $fight = MobFight::where('user_id', $userId)->get();
        if (count($fight) == 0)
            return true;

        $fight = $fight->first();

        return $fight->running;
    }

    public function updateFight() {
        $user = Auth::user();
        $fight = MobFight::where('user_id', $user->id)->get()->first();

        $hpskill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', Constants::$HP)->get()->first();

        $hp = $fight->user_hp;
        $maxhp = $hpskill->getLevel();
        //$mob = Mob::find($fight->mob_id);

        $loot = Loot::where('user_id', $user->id)
            ->where('mob_fight_id', $fight->id)->get();
        $loots = array();
        $item = Item::find(1);
        foreach ($loot as $l) {
            $toAdd = array();
            $toAdd['item_id'] = $l->item_id;
            $toAdd['amount'] = $l->amount;
            $toAdd['icon'] = url($item->getIconPath($l->item_id));
            array_push($loots, $toAdd);
        }

        if (!MobController::mobFightRunning($user->id)) {
            $end = 1;
            return response()->json(['hp'=> $hp, 'maxhp' => $maxhp, 'end'=>$end, 'kills' => $fight->kills, 'loot' => $loots]);
        } else {
            $end = 0;
        }

        return response()->json(['hp'=> $hp, 'maxhp' => $maxhp, 'end' => $end, 'loot' => $loots]);
    }
}
