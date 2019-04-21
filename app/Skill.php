<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'icon'
    ];

    public function getName($id) {
        $item = Skill::where('id', $id)->get()->first();
        $name = $item->name;
        return $name;
    }

    public function getIconPath($id) {
        $item = Skill::where('id', $id)->get()->first();
        $icon = $item->icon;
        return "/img/skills/".$icon.'.png';
    }

    public function getSkillCount() {
        return Skill::count();
    }
}
