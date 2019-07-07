<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{

    public function titlesIndex() {
        $titles = TitleController::getTitles();
        return view('titles', array(
            'titles' => $titles
        ));
    }

    public static function getTitles() {
        return array(
            array("", "", ""),
            array("Mage", "A title for mages.", "blue"),
            array("Archer", "A title for archers.", "green"),
            array("Warrior", "A title for warriors.", "red")
        );
    }

    public function selectTitle(Request $request) {
        $user = Auth::user();
        $user->title = $request['id'];
        $user->save();
        return redirect('titles')->with('success', "Title selected: '".TitleController::getTitles()[$request['id']][0]."'");
    }

    public function removeTitle(Request $request) {
        $user = Auth::user();
        $user->title = 0;
        $user->save();
        return redirect('titles')->with('success', 'Title removed.');
    }
}
