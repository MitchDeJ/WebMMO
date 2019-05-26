<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEquip extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database
    public $table = 'user_equips';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'equip_slot', 'item_id'
    ];


    public function equip($user, $invslotnum) {
        $invslot = InventorySlot::where('user_id', $user->id)
            ->where('slot', $invslotnum)->get()->first();
        $item = Item::findOrFail($invslot->item_id);

        $old = $this->item_id;

        $this->item_id = $item->id;

        $invslot->removeItemInSlot();

        if ($old != null) {
            $invslot->item_id = $old;
            $invslot->save();
        }


        $this->save();
    }


    public function getSlotPlaceholder() {
        switch($this->equip_slot) {
            case 0:
                return "/img/icons/placeholder_helm.png";
            case 1:
                return "/img/icons/placeholder_body.png";
            case 2:
                return "/img/icons/placeholder_legs.png";
            case 3:
                return "/img/icons/placeholder_weapon.png";
            case 4:
                return "/img/icons/placeholder_shield.png";
            case 5:
                return "/img/icons/placeholder_amulet.png";
        }
    }
}
