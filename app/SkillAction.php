<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillAction extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'skill_id', 'xp_amount', 'success_chance', 'delay', 'tool_item', 'req_item', 'req_item_amount',
        'req_item_2', 'req_item_2_amount', 'product_item', 'product_item_amount', 'req_level'
    ];

    public function getUserMaxAmount($userId) {
        $inv = InventorySlot::getInstance();
        $user = User::find($userId);
        $item = Item::find(1);
        $req_count = -1;
        $req_count_2 = -1;

        $freeSlots = $inv->getFreeSlots($user->id);

        if ($this->req_item != null && !$item->isStackable($this->req_item))
            $freeSlots +=  $inv->getItemCount($user->id, $this->req_item);

        if ($this->req_item_2 != null && !$item->isStackable($this->req_item_2))
            $freeSlots +=  $inv->getItemCount($user->id, $this->req_item_2);

        if ($this->req_item != null) {
            $req_count = $inv->getItemCount($user->id, $this->req_item);
            $req_count = floor($req_count / $this->req_item_amount);
        }
        if ($this->req_item_2 != null) {
            $req_count_2 = $inv->getItemCount($user->id, $this->req_item_2);
            $req_count_2 = floor($req_count_2 / $this->req_item_2_amount);
        }

        //if 2 item requirements
        if ($req_count != -1 && $req_count_2 != -1) {
            $req_count = min($req_count, $req_count_2);
        }

        if ($req_count > $freeSlots)
            $req_count = $freeSlots;

        //if 1 requirement
        return $req_count;
    }
}
