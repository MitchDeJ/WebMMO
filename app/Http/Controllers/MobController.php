<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Jobs\ApplyMobKill;
use App\Mob;
use App\MobSpawn;
use App\UserSkill;
use App\MobFight;
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

        return view('mobfight', array(
            'hp' => $hp,
            'maxhp' => $maxhp,
            'kills' => $kills,
            'mob' => $mob
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

        DB::table('mob_fights')->insert([
            'user_id' => $userId,
            'mob_id' => $mobId,
            'kills' => 0,
            'user_hp' => $hp,
            'start' => time()
        ]);

        //queue job
        $timeToKill = Combat::getTimeToKill($userId, $mobId);
        ApplyMobKill::dispatch($userId, $mobId)
            ->delay(now()->addSeconds($timeToKill));
    }

    public static function inMobFight($userId) {
        $fight = MobFight::where('user_id', $userId)->get();
        if (count($fight) > 0)
            return true;

        return false;
    }

    public function updateFight() {
        $user = Auth::user();
        $fight = MobFight::where('user_id', $user->id)->get();
        if (!MobController::inMobFight($user->id)) {
            $end = 1;
            return response()->json(['end'=>$end]);
        } else {
            $fight = $fight->first();
            $end = 0;
        }

        $hpskill = UserSkill::where('user_id', $user->id)
            ->where('skill_id', Constants::$HP)->get()->first();

        $hp = $fight->user_hp;
        $maxhp = $hpskill->getLevel();
        $kills = $fight->kills;
        $mob = Mob::find($fight->mob_id);
        $xp = $mob->hitpoints * Constants::$XP_PER_DAMAGE * $kills;

        return response()->json(['hp'=> $hp, 'maxhp' => $maxhp, 'kills' => $kills, 'xp' => $xp, 'end' => $end]);
    }
}
