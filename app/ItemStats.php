<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStats extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database
    public $table = 'item_stats';

    protected $fillable = [
        'item_id', 'melee', 'melee_defence', 'ranged', 'ranged_defence', 'magic', 'magic_defence'
    ];

    public static function getStatTotal($user, $stat) {
        $equips = UserEquip::where('user_id', $user)->get();
        $total = 0;
        foreach($equips as $e) {
            $s = ItemStats::where('item_id', $e->item_id)->get()->first();
            $total += $s->pluck($stat)->first();
        }
        return $total;
    }

}
