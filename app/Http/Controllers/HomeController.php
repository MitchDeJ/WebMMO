<?php

namespace App\Http\Controllers;

use App\Item;
use App\Skill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', array(
            'item' => Item::findOrFail(1),
            'skill' => Skill::findOrFail(1)
        ));
    }
}
