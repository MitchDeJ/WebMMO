<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MapPoint;
use Auth;
use App\Area;

class MapController extends Controller
{
    public function index() {

        $allpoints = MapPoint::all();
        $points = array();
        foreach($allpoints as $p) {
            $toAdd = array();
            $area = Area::find($p->area_id);
            $toAdd['title'] = $area->name;
            $toAdd['x'] = $p->x;
            $toAdd['y'] = $p->y;
            $toAdd['id'] = $area->id;
            array_push($points, $toAdd);
        }

        return view('map')->with(array(
            'points' => $points,
            'current' => Auth::user()->area_id
        ));
    }

    public function travel(Request $request) {
        $user = Auth::user();
        $areaId = $request['id'];

        $area = Area::where('id', $areaId)->get();

        if (count($area) == 0)
            return redirect('map')->with('fail', 'Invalid area.');

        if ($user->area_id == $areaId)
            return redirect('map')->with('fail', 'You are already in that area.');

        $user->area_id = $areaId;
        $user->save();

        return redirect('map');
    }
}
