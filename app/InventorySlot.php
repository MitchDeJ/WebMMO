<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventorySlot extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database
    public $INV_SIZE = 28;

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
        return InventorySlot::findOrFail(1);
    }

    public function getInventory($userId)
    {
        $slots = array();
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slots[$i] = InventorySlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
        }
        return $slots;
    }

    function getFreeSlot($userId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = InventorySlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == null)
                return $slot->slot;
        }
        return null;
    }

    public function hasItem($userId, $itemId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = InventorySlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == $itemId)
                return true;
        }
        return false;
    }

    function getSlotOfItem($userId, $itemId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = InventorySlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id == $itemId)
                return $slot;
        }
        return null;
    }

    function getItemOfSlot($userId, $slot)
    {
        $result = InventorySlot::where('user_id', $userId)
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
                $slot = InventorySlot::where('slot', $slotNum)->where('user_id', $userId)->get()->first();
                $slot->item_id = $itemId;
                $slot->amount = $amount;
            }
        } else { //non-stackable items
            $slotNum = $freeSlot;
            $slot = InventorySlot::where('slot', $slotNum)->where('user_id', $userId)->get()->first();
            $slot->item_id = $itemId;
            $slot->amount = 1;
        }
        $slot->save();
    }

    public function getItemCount($userId, $itemId)
    {
        if (Item::isStackable($itemId)) {
            for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
                $slot = InventorySlot::where('user_id', $userId)
                    ->where('slot', $i)->get()->first();
                if ($slot->item_id == $itemId)
                    return $slot->amount;
            }
            return 0;
        } else {
            $amount = 0;
            for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
                $slot = InventorySlot::where('user_id', $userId)
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
            }
        } else { //non stackables
            for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {

                if ($amount == 0)
                    break;

                $slot = InventorySlot::where('user_id', $userId)
                    ->where('slot', $i)->get()->first();
                if ($slot->item_id == $itemId) {
                    $slot->item_id = null;
                    $slot->amount = 0;
                    $amount -= 1;
                }

            }
        }
        $slot->save();
    }

    public function getNextFoodItem($userId)
    {
        for ($i = 1; $i <= $this->INV_SIZE; $i += 1) {
            $slot = InventorySlot::where('user_id', $userId)
                ->where('slot', $i)->get()->first();
            if ($slot->item_id != null) {
                if (Item::find($slot->item_id)->isFood($slot->item_id))
                    return $slot;
            }
        }
        return null;
    }

    public function clear() {
        $this->item_id = null;
        $this->amount = 0;
        $this->save();
    }

}
