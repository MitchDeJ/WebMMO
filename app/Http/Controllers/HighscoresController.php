<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Skill;
use App\User;
use Illuminate\Http\Request;

class HighscoresController extends Controller
{

    public function redirect() {
        return $this->index(1);
    }

    public function index($pageNum)
    {
        $perPage = Constants::$PLAYERS_PER_PAGE;

        $sorted = User::all()
            ->sortBy(function ($user) {return $user->getTotalLevel();})
            ->sortBy(function ($user) {return $user->getTotalXp();})
            ->reverse()
            ->slice(0+($perPage*($pageNum-1)), $perPage);

        $pages = ceil(User::count()/$perPage);

        return view('highscores', array(
            'users' => $sorted,
            'hsname' => "Total level",
            'pages' => $pages,
            'num' => $pageNum,
            'perPage' => $perPage
        ));
    }

    public function skillIndex($skillname, $pageNum)
    {
        $skill = Skill::where('name', ucfirst($skillname))->get()->first();

        $perPage = Constants::$PLAYERS_PER_PAGE;

        $pages = ceil(User::count()/$perPage);

        if (!$skill)
            return redirect('highscores')->with('fail', 'Invalid highscores table.');

        $sorted = User::all()
            ->sortBy(function ($user) use ($skill) {return $user->getLevel($skill->id);})
            ->sortBy(function ($user) use ($skill) {return $user->getXp($skill->id);})
            ->reverse()
            ->slice(0+($perPage*($pageNum-1)), $perPage);

        return view('highscores', array(
            'users' => $sorted,
            'hsname' => ucfirst($skillname).' level',
            'skill' => $skill,
            'pages' => $pages,
            'num' => $pageNum,
            'perPage' => $perPage
        ));
    }

    public function getPage(Request $request) {
        $num = $request['pageselected'];
        $skill = $request['skill'];

        if (!$skill) {
            return redirect('highscores/' . $num);
        } else {
            return redirect('highscores/' . $skill . "/" . $num);
        }

    }

}
