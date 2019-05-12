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
        'user_id', 'mob_id', 'kills', 'user_hp', 'damage_stack', 'start', 'last_update', 'running'
    ];


    public function heal($amount)
    {
        $user = User::find($this->user_id);
        $this->increment('user_hp', $amount);

        //prevent overhealing
        $hp = UserSkill::where('user_id', $user->id)
            ->where('skill_id', Constants::$HP)->get()->first();
        $level = $hp->getLevel();
        if ($this->user_hp > $level) {
            $this->user_hp = $level;
            $this->save();
        }
    }

    public function addLoot()
    {
        $mob = Mob::find($this->mob_id);
        $drop = $mob->getLootTable()->getDrop();
        $match = Loot::where('user_id', $this->user_id)
            ->where('item_id', $drop['item_id'])->get();
        if (count($match) > 0) {
            $match = $match->first();
            $match->increment('amount', $drop['amount']);
        } else {
            Loot::create([
                'user_id' => $this->user_id,
                'mob_fight_id' => $this->id,
                'item_id' => $drop['item_id'],
                'amount' => $drop['amount']
            ]);
        }
    }

    public function claimLoot()
    {
        $user = User::find($this->user_id);
        $loot = Loot::where('user_id', $user->id)->get();
        $inv = InventorySlot::getInstance();
        foreach ($loot as $l) { //TODO check if user has inventory space.
            if (Item::isStackable($l->item_id)) {
                if ($inv->getFreeSlots($user->id) > 0 || $inv->hasItem($user->id, $l->item_id)) {
                    $inv->addItem($user->id, $l->item_id, $l->amount);
                    $l->delete();
                }
            } else {
                $canGive = $inv->getFreeSlots($user->id);
                $toGive = $l->amount;

                if ($toGive > $canGive)
                    $toGive = $canGive;

                $inv->addItem($user->id, $l->item_id, $toGive);
                $l->decrement('amount', $toGive);
                if ($l->amount <= 0)
                    $l->delete();
            }
        }
    }
}
