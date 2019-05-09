<?php

namespace App\Jobs;

use App\Combat;
use App\InventorySlot;
use App\Item;
use App\MobFight;
use App\Mob;
use App\Constants;
use App\User;
use App\UserSkill;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ApplyMobKill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    public $mobId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $mobId)
    {
        $this->userId = $userId;
        $this->mobId = $mobId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->userId);
        $mob = Mob::find($this->mobId);
        $fight = MobFight::where('user_id', $this->userId)
            ->where('mob_id', $this->mobId)->get()->first();

        //calculate the damage done using the damage stack
        $stack = $fight->damage_stack;
        $n = Combat::getDamageTakenPerKill($this->userId, $this->mobId) + $stack;
        $damage = floor($n);
        $fraction = $n - $damage;
        $fight->damage_stack = $fraction;
        $fight->save();
        $nextdamage = floor(Combat::getDamageTakenPerKill($this->userId, $this->mobId) + $fight->damage_stack);

       // remove player health in fight instance
        $fight->decrement('user_hp', $damage);

        // add loot

        //give experience TODO get attack style instead of melee xp only
        $skill = UserSkill::where('user_id', $this->userId)
            ->where('skill_id', Constants::$MELEE)->get()->first();
        $skill->addXp(Constants::$XP_PER_DAMAGE * $mob->hitpoints);

        //increment kills
        $fight->increment('kills', 1);

        $inv = InventorySlot::getInstance();
        //consume food if necessary
        while($fight->user_hp <=  $nextdamage
            && $inv->getNextFoodItem($user->id) != null) {
            $slot = $inv->getNextFoodItem($user->id); // get the item slot
            $item = Item::find($slot->item_id); // get the food item
            $fight->heal($item->getHealAmount($item->id)); // heal the player
            $slot->clear();
        }

        //queue another mobkill after gettimetokill
        if ($fight->user_hp >=  $nextdamage && $fight->user_hp > 0) {
            $timeToKill = Combat::getTimeToKill($this->userId, $this->mobId);
            ApplyMobKill::dispatch($this->userId, $this->mobId)
                ->delay(now()->addSeconds($timeToKill));
        } else { //not enough hp or food
            //stop the fight.
            //TODO zelf de fight 'completen' en verwijderen met een knop ipv auto delete
            $fight->delete();
        }
    }
}
