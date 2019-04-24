<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cooldown extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'end'
    ];

    public static function check($user, $type)
    {
        $cds = Cooldown::where('user_id', $user)->get();

        if ($cds->count() == 0)
            return false;

        foreach ($cds as $cd) {
            if (time() >= $cd->end) { //remove expired cooldowns
                $cd->delete();
            } else {
                if ($cd->type == $type) {//we have found a cooldown
                    return $cd->getTimeRemaining();
                }
            }
        }
        return false;
    }
    public function getTimeRemaining() {
        $current = time();
        $end = $this->end;
        $remain = $end - $current;
        return $remain;
    }
}
