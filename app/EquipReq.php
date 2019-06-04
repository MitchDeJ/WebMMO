<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipReq extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
        'item_id', 'skill_id', 'level'
    ];

    public static function check($userId, $itemId) {

        $reqs = EquipReq::where('item_id', $itemId)->get();

        if (!$reqs)
            return true;

        foreach($reqs as $req) {
            $userLevel = UserSkill::where('user_id', $userId)
                ->where('skill_id', $req->skill_id)->get()->first()->getLevel();
            if($userLevel < $req->level)
                return false;
        }
        return true;
    }
}
