<?php

namespace App\Http\Controllers;

use App\Mob;
use App\MobSpawn;
use App\Npc;
use Illuminate\Http\Request;
use Auth;
use App\Item;
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

        if (MobController::inMobFight($user->id))
            return redirect('mobfight');

        $loc = Auth::user()->location;
        $spots = SkillSpot::where('area_id', $loc->id)->get();
        $reqs = array();
        $spawns = MobSpawn::where('area_id', $loc->id)->get();
        $mobs = array();

        foreach($spawns as $spawn) {
            array_push($mobs, Mob::find($spawn->mob_id));
        }


        foreach($spots as $spot) {
            $reqs[$spot->id] = SpotRequirement::where('spot_id', $spot->id)->get();
        }

        return view('location', array(
            'item' => Item::find(1),
            'skill' => Skill::find(1),
            'location' => $loc,
            'skillspots' => $spots,
            'npcs' => Npc::where('area_id', $loc->id)->get(),
            'reqs' => $reqs,
            'mobs' => $mobs
        ));
    }
}
