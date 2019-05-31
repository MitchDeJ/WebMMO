<?php

namespace App\Http\Controllers;

use App\News;
use App\Skill;
use App\UserSkill;
use Auth;
use App\User;
use File;
use Image;
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
            'user' => $user,
            'skills' => $skills,
            'levels' => $levels,
            'xps' => $xps,
            'news' => $news
        ));
    }

    public function editIndex()
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

        return view('editprofile', array(
            'user' => $user,
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
            'user' => $user,
            'skills' => $skills,
            'levels' => $levels,
            'xps' => $xps,
            'news' => $news
        ));
    }

    public function updateAvatar(Request $request)
    {
        //upload avatar
        if ($request->hasFile('avatar')) {
            $user = Auth::user();
            $avatar = $request->file('avatar');
            $ext = $avatar->getClientOriginalExtension();
            if ($ext != "png" && $ext != "jpg" && $ext != "jpeg")
                return redirect("editprofile")->with("fail", "Invalid image file type.");
            $filename = $user->name . time() . '.' . $ext;
            if ($user->avatar != "default.png")
                File::Delete(public_path("/userimg/") . $user->avatar);
            Image::make($avatar)->resize(150, 150)->save(public_path('/user_img/' . $filename));
            $user->avatar = $filename;
            $user->save();
        }
        return redirect('editprofile/')->with('success', 'Updated avatar.');
    }

    public function updateDescription(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'desc' => 'Required|max:400'
        ]);
        $user->description = $request['desc'];
        $user->save();
        return redirect('editprofile')->with('success', 'Updated description.');
    }
}
