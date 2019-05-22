<?php

namespace App\Http\Controllers;

use App\News;
use App\Skill;
use App\UserSkill;
use Auth;
use App\User;
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
        $news = News::where('user_id', $user->id)->get()->reverse()
        ->take(5);

        foreach ($skills as $skill) {
            $us = UserSkill::where('user_id', $user->id)
                ->where('skill_id', $skill->id)->get()->first();
            $levels[$skill->id] = $us->getLevel();
            $xps[$skill->id] = $us->getXp();
        }

        return view('profile', array(
            'skills' => $skills,
            'levels' => $levels,
            'xps' => $xps,
            'news' => $news
        ));
    }

    public function indexByName($name) {
        $user = User::where('name', $name)->get()->first();

        if (!$user)
            return redirect('profile');

        $skills = Skill::all();
        $levels = array();
        $xps = array();
        $news = News::where('user_id', $user->id)->get()->reverse()
            ->take(5);

        foreach ($skills as $skill) {
            $us = UserSkill::where('user_id', $user->id)
                ->where('skill_id', $skill->id)->get()->first();
            $levels[$skill->id] = $us->getLevel();
            $xps[$skill->id] = $us->getXp();
        }

        return view('profile', array(
            'skills' => $skills,
            'levels' => $levels,
            'xps' => $xps,
            'news' => $news
        ));
    }
}
