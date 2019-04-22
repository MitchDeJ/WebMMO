<?php

namespace App\Http\Controllers;

use App\Npc;
use Illuminate\Http\Request;
use Auth;
use App\Item;
use App\Skill;
use App\SkillSpot;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $loc = Auth::user()->location;
        return view('location', array(
            'item' => Item::find(1),
            'skill' => Skill::find(1),
            'location' => $loc,
            'skillspots' => SkillSpot::where('area_id', $loc->id)->get(),
            'npcs' => Npc::where('area_id', $loc->id)->get()
        ));
    }
}
