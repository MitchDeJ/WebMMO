<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobFight extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'mob_id', 'kills', 'user_hp', 'damage_stack', 'start'
    ];


    public function heal($amount) {
        $user = User::find($this->user_id);
        $this->increment('user_hp', $amount);

        //prevent overhealing
        $hp = UserSkill::where('user_id', $user->id)
            ->where('skill_id', Constants::$HP)->get()->first();
        $level =  $hp->getLevel();
        if ($this->user_hp > $level) {
            $this->user_hp = $level;
            $this->save();
        }
    }
}
