<?php

namespace App\Http\Controllers;

use App\Skill;
use App\UserSkill;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $skills = Skill::all();
        $levels = array();
        $xps = array();

        foreach ($skills as $skill) {
            $us = UserSkill::where('player_id', $user->id)
                ->where('skill_id', $skill->id)->get()->first();
            $levels[$skill->id] = $us->getLevel();
            $xps[$skill->id] = $us->getXp();
        }

        return view('profile', array(
            'skills' => $skills,
            'levels' => $levels,
            'xps' => $xps
        ));
    }
}
