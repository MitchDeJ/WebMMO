<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\UserDialogue;
use App\Dialogue;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false; //add this when we dont need the timestamps in our database
    private $processingEquip = false; //prevent unequip duping

    public function addFlag($flag, $value)
    {
        if ($this->hasFlag($flag))
            return;

        UserFlag::create([
            'user_id' => $this->id,
            'flag' => $flag,
            'value' => $value
        ]);
    }

    public function removeFlag($flag)
    {
        $flag = UserFlag::where('user_id', $this->id)
            ->where('flag', $flag)->get()->first();

        if (!$flag)
            return;

        $flag->delete();
    }

    public function hasFlag($flag)
    {
        $flag = UserFlag::where('user_id', $this->id)
            ->where('flag', $flag)->get()->first();

        if (!$flag)
            return false;

        return true;
    }

    public function getFlag($flag) {
        $flag = UserFlag::where('user_id', $this->id)
            ->where('flag', $flag)->get()->first();

        if (!$flag)
            return false;

        return $flag->value;
    }

    public function getGP()
    {
        $inv = InventorySlot::getInstance();
        $gp = $inv->getItemCount($this->id, 17);
        return $gp;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'avatar', 'account_created_at', 'area_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function location()
    {
        return $this->hasOne('App\Area', 'id', 'area_id');
    }

    public function setDialogue($dId)
    {
        $dialogue = Dialogue::find($dId);

        $current = UserDialogue::where('user_id', $this->id)->get();
        if (count($current) == 0) {
            //create a new row.
            UserDialogue::create(array(
                'user_id' => $this->id,
                'dialogue_id' => $dialogue->id
            ));
        } else {
            //update existing row
            $current = $current->first();
            $current->dialogue_id = $dialogue->id;
            $current->save();
        }
    }

    public function getDialogue()
    {
        return UserDialogue::where('user_id', $this->id)->get()->first()->dialogue_id;
    }

    public function getXp($skill)
    {
        $skill = UserSkill::where('user_id', $this->id)
            ->where('skill_id', $skill)->get()->first();
        return $skill->getXp();
    }

    public function getLevel($skill)
    {
        $skill = UserSkill::where('user_id', $this->id)
            ->where('skill_id', $skill)->get()->first();
        return $skill->getLevel();
    }

    public function getTotalXp()
    {
        $skills = UserSkill::where('user_id', $this->id)->get();
        $total = 0;
        foreach ($skills as $s) {
            $total += $s->getXp();
        }
        return $total;
    }

    public function getTotalLevel()
    {
        $skills = UserSkill::where('user_id', $this->id)->get();
        $total = 0;
        foreach ($skills as $s) {
            $total += $s->getLevel();
        }
        return $total;
    }

    public function setCombatFocus($f)
    {
        $focus = CombatFocus::where('user_id', $this->id)->get();

        if (count($focus) == 0) {
            CombatFocus::create([
                'user_id' => $this->id,
                'focus_type' => $f
            ]);
        } else {
            $focus = $focus->first();
            $focus->focus_type = $f;
            $focus->save();
        }
    }

    public function getCombatFocus() {
        $focus = CombatFocus::where('user_id', $this->id)->get()->first();
        return $focus->focus_type;
    }
}
