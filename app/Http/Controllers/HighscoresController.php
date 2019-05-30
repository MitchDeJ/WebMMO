<?php

namespace App\Http\Controllers;

use App\Skill;
use App\User;
use Illuminate\Http\Request;

class HighscoresController extends Controller
{
    public function index()
    {

        $sorted = User::all()
            ->sortBy(function ($user) {return $user->getTotalLevel();})
            ->sortBy(function ($user) {return $user->getTotalXp();})
            ->reverse();

        return view('highscores', array(
            'users' => $sorted,
            'hsname' => "Total level"
        ));
    }

    public function skillIndex($skillname)
    {
        $skill = Skill::where('name', ucfirst($skillname))->get()->first();

        if (!$skill)
            return redirect('highscores')->with('fail', 'Invalid highscores table.');

        $sorted = User::all()
            ->sortBy(function ($user) use ($skill) {return $user->getLevel($skill->id);})
            ->sortBy(function ($user) use ($skill) {return $user->getXp($skill->id);})
            ->reverse();

        return view('highscores', array(
            'users' => $sorted,
            'hsname' => ucfirst($skillname).' level',
            'skill' => $skill
        ));
    }

}
