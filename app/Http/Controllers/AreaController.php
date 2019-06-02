<?php

namespace App\Http\Controllers;

use App\AreaObject;
use App\AreaObjectSpawn;
use App\Mob;
use App\MobSpawn;
use App\Npc;
use App\Constants;
use Illuminate\Http\Request;
use Auth;
use App\Cooldown;
use App\Item;
use App\User;
use App\Skill;
use App\SkillSpot;
use App\SpotRequirement;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $skill = Skill::find(1);

        if (MobController::inMobFight($user->id))
            return redirect('mobfight');

        if (SkillActionController::inSkillAction($user->id))
            return redirect('skillaction');

        $loc = Auth::user()->location;
        $spots = SkillSpot::where('area_id', $loc->id)->get();
        $reqs = array();
        $mobspawns = MobSpawn::where('area_id', $loc->id)->get();
        $mobs = array();

        foreach ($mobspawns as $spawn) {
            array_push($mobs, Mob::find($spawn->mob_id));
        }

        $objectspawns = AreaObjectSpawn::where('area_id', $loc->id)->get();
        $objects = array();

        foreach ($objectspawns as $spawn) {
            $obj = AreaObject::find($spawn->object_id);
            array_push($objects, $obj);
        }


        foreach ($spots as $spot) {
            $reqs[$spot->id] = SpotRequirement::where('spot_id', $spot->id)->get();
        }

        $cd = Cooldown::check($user->id, Constants::$COOLDOWN_SKILLING);
        if ($cd == false)
            $cd = 0;

        $combatcd = Cooldown::check($user->id, Constants::$COOLDOWN_COMBAT);
        if ($combatcd == false)
            $combatcd = 0;

        $players = User::where('area_id', $loc->id)
            ->where('id', '!=', $user->id)->get();

        return view('location', array(
            'item' => Item::find(1),
            'skill' => Skill::find(1),
            'location' => $loc,
            'skillspots' => $spots,
            'npcs' => Npc::where('area_id', $loc->id)->get(),
            'reqs' => $reqs,
            'mobs' => $mobs,
            'objects' => $objects,
            'players' => $players,
            'cd' => $cd,
            'combatcd' => $combatcd
        ));
    }
}
