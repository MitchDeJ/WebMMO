<?php

namespace App\Jobs;

use App\Combat;
use App\CombatFocus;
use App\Http\Controllers\MobController;
use App\InventorySlot;
use App\Item;
use App\MobFight;
use App\Mob;
use App\Constants;
use App\User;
use App\UserSkill;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
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

        if (!MobController::inMobFight($user->id))
            return;

        if (!MobController::mobFightRunning($user->id))
            return;

        $fight = MobFight::where('user_id', $this->userId)
            ->where('mob_id', $this->mobId)->get()->first();

        $inv = InventorySlot::getInstance();

        //calculate the damage done using the damage stack
        $stack = $fight->damage_stack;
        $n = Combat::getDamageTakenPerKill($this->userId, $this->mobId) + $stack;
        $damage = floor($n);
        $fraction = $n - $damage;
        $fight->damage_stack = $fraction;
        $fight->last_update = time();
        $fight->save();
        $nextdamage = floor(Combat::getDamageTakenPerKill($this->userId, $this->mobId) + $fight->damage_stack);

        // remove player health in fight instance
        $fight->decrement('user_hp', $damage);

        //check if we managed to get the first kill
        if ($fight->kills == 0) {
            while ($fight->user_hp <= 0
                && $inv->getNextFoodItem($user->id) != null) {
                $slot = $inv->getNextFoodItem($user->id); // get the item slot
                $item = Item::find($slot->item_id); // get the food item
                $fight->heal($item->getHealAmount($item->id)); // heal the player
                $slot->clear();
            }

            //we didnt manage to kill a single mob.
            if ($fight->user_hp <= 0) {
                $fight->running = false;
                $fight->user_hp = 0;
                $fight->save();
                return;
            }
        }


        // add loot
        $fight->addLoot();

        //give experience
        $styleSkill = Combat::getSkillForStyle(Combat::getUserAttackStyle($user->id));
        $hpSkill = UserSkill::where('user_id', $this->userId)
            ->where('skill_id', Constants::$HP)->get()->first();
        $defSkill = UserSkill::where('user_id', $this->userId)
            ->where('skill_id', Constants::$DEFENCE)->get()->first();
        $skill = UserSkill::where('user_id', $this->userId)
            ->where('skill_id', $styleSkill)->get()->first();

        if ($user->getCombatFocus() == Constants::$FOCUS_PRIMARY) {
            $skill->addXp(Constants::$XP_PER_DAMAGE * $mob->hitpoints);
        } else if ($user->getCombatFocus() == Constants::$FOCUS_SHARED) {
            $skill->addXp((Constants::$XP_PER_DAMAGE / 2) * $mob->hitpoints);
            $defSkill->addXp((Constants::$XP_PER_DAMAGE / 2) * $mob->hitpoints);
        } else if ($user->getCombatFocus() == Constants::$FOCUS_DEFENCE) {
            $defSkill->addXp(Constants::$XP_PER_DAMAGE * $mob->hitpoints);
        }

        //hp xp
        $hpSkill->addXp((Constants::$XP_PER_DAMAGE / 4) * $mob->hitpoints);

        //increment kills
        $fight->increment('kills', 1);

        //consume food if necessary
        while ($fight->user_hp <= $nextdamage
            && $inv->getNextFoodItem($user->id) != null) {
            $slot = $inv->getNextFoodItem($user->id); // get the item slot
            $item = Item::find($slot->item_id); // get the food item
            $fight->heal($item->getHealAmount($item->id)); // heal the player
            $slot->clear();
        }

        //queue another mobkill after gettimetokill
        if ($fight->user_hp >= $nextdamage && $fight->user_hp > 0) {
            $timeToKill = Combat::getTimeToKill($this->userId, $this->mobId);
            ApplyMobKill::dispatch($this->userId, $this->mobId)
                ->delay(now()->addSeconds($timeToKill)->addSeconds($mob->respawn)->subMillis(Constants::$JOB_PROCESS_DELAY));
        } else { //not enough hp or food
            //stop the fight.
            $fight->running = false;
            $fight->user_hp = 0;
            $fight->save();
        }
    }
}
