<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankSlot extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database
    public $INV_SIZE = 70;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'slot', 'item_id', 'amount'
    ];

    public static function getInstance()
    {
        return BankSlot::findOrFail(1);
    }

    public function isBank() {
        return true;
    }

    public function getBank($userId)
    {
        $slots = array();
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slots[$i] = BankSlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
        }
        return $slots;
    }

    function getFreeSlot($userId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = BankSlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == null)
                return $slot->slot;
        }
        return null;
    }

    function getFreeSlots($userId)
    {
        $count = 0;
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = BankSlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == null)
                $count++;
        }
        return $count;
    }

    public function hasItem($userId, $itemId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = BankSlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == $itemId)
                return true;
        }
        return false;
    }

    function getSlotOfItem($userId, $itemId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = BankSlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == $itemId)
                return $slot;
        }
        return null;
    }

    function getItemOfSlot($userId, $slot)
    {
        $result = BankSlot::where('user_id', $userId)
            ->where('slot', $slot)->get()->first();
        $item = Item::where('id', $result->item_id)->get();
        if (count($item) > 0)
            return $item->first();
        else
            return null;
    }

    public function addItem($userId, $itemId, $amount)
    {

        $freeSlot = $this->getFreeSlot($userId);

        if ($freeSlot == null) {
            return false; // no free space.
        }

        //stackable items
        if (Item::isStackable($itemId)) {
            if ($this->hasItem($userId, $itemId)) {
                $slot = $this->getSlotOfItem($userId, $itemId);
                $slot->increment('amount', $amount);
            } else {
                $slotNum = $freeSlot;
                $slot = BankSlot::where('slot', $slotNum)->where('user_id', $userId)->get()->first();
                $slot->item_id = $itemId;
                $slot->amount = $amount;
                $slot->save();
            }
        } else { //non-stackable items
            for ($i=0; $i<$amount; $i++) {
                $freeSlot = $this->getFreeSlot($userId);
                if ($freeSlot == null)
                    return false;
                $slotNum = $freeSlot;
                $slot = BankSlot::where('slot', $slotNum)->where('user_id', $userId)->get()->first();
                $slot->item_id = $itemId;
                $slot->amount = 1;
                $slot->save();
            }
        }
    }

    public function getItemCount($userId, $itemId)
    {
        if (Item::isStackable($itemId)) {
            for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
                $slot = BankSlot::where('user_id', $userId)
                    ->where('slot', $i)->get()->first();
                if ($slot->item_id == $itemId)
                    return $slot->amount;
            }
            return 0;
        } else {
            $amount = 0;
            for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
                $slot = BankSlot::where('user_id', $userId)
                    ->where('slot', $i)->get()->first();
                if ($slot->item_id == $itemId)
                    $amount += 1;
            }
            return $amount;
        }
    }

    public function removeItemInSlot()
    {
        $this->item_id = null;
        $this->amount = 0;
        $this->save();
    }

    public function removeItem($userId, $itemId, $amount)
    {
        $count = $this->getItemCount($userId, $itemId);

        if ($count == 0)
            return false;

        if (Item::isStackable($itemId)) {
            $slot = $this->getSlotOfItem($userId, $itemId);
            if ($count > $amount) {
                $slot->decrement('amount', $amount);
            } else {
                $slot->item_id = null;
                $slot->amount = 0;
                $slot->save();
            }
        } else { //non stackables
            for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {

                if ($amount == 0)
                    break;

                $slot = BankSlot::where('user_id', $userId)
                    ->where('slot', $i)->get()->first();
                if ($slot->item_id == $itemId) {
                    $slot->item_id = null;
                    $slot->amount = 0;
                    $slot->save();
                    $amount -= 1;
                }

            }
        }
        return false;
    }

    public function clear() {
        $this->item_id = null;
        $this->amount = 0;
        $this->save();
    }

}
