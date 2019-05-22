<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{

    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xp_amount', 'skill_id', 'user_id'
    ];

    public function addXP($amount) {
        $startlevel = $this->levelForXp($this->xp_amount);
        $this->increment('xp_amount', $amount);
        $endlevel = $this->levelForXp($this->xp_amount);

        if ($endlevel > $startlevel) {
            $this->levelUp($this->user_id, $this->skill_id, $endlevel);
        }
    }

    public function getLevel() {
        return $this->levelForXp($this->xp_amount);
    }

    public function getXp() {
        return $this->xp_amount;
    }

    public function getXpRequired() {
        $level = getLevel($this->user_id, $this->skill_id);
        $req = $this->xpForLevel($level + 1) - $this->xp_amount;
        return $req;
    }

    function xpForLevel($level) {
        $xp = 0;
        $result = 0;
        for ($i = 0; $i <= $level; $i++) {
            $xp += floor($i + 317 * pow(2, $i / 7.));
            $result = floor($xp / 4);
        }
        return $result;
    }

    function levelForXp($xp) {
        $points = 0;
        for ($i = 1; $i <= 120; $i++) {
            $points += floor($i + 317 * pow(2, $i / 7.));
            $result = floor($points / 4);
            if ($result >= $xp) {
                return $i;
            }
        }
        return 120;
    }


    function levelUp($playerId, $skillId, $level) {
        $skill = Skill::find($skillId);

        News::create([
            'user_id' => $playerId,
            'message' => 'has achieved level '.$level.' '.$skill->getName($skillId).'.',
            'timestamp' => time()
        ]);
    }
}
