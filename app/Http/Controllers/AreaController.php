<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('location', array(
            'location' => Auth::user()->location
        ));
    }
}
