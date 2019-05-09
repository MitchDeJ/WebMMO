<?php

namespace App\Jobs;

use App\Combat;
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

       // remove player health in fight instance
        $fight->decrement('user_hp', Combat::getDamageTakenPerKill($this->userId, $this->mobId));

        // add loot

        //give experience TODO get attack style instead of melee xp only
        $skill = UserSkill::where('user_id', $this->userId)
            ->where('skill_id', Constants::$MELEE)->get()->first();
        $skill->addXp(Constants::$XP_PER_DAMAGE * $mob->hitpoints);

        //increment kills
        $fight->increment('kills', 1);

        //consume food if necessary TODO

        //queue another mobkill after gettimetokill

        if ($fight->user_hp >  Combat::getDamageTakenPerKill($this->userId, $this->mobId)) {
            $timeToKill = Combat::getTimeToKill($this->userId, $this->mobId);
            ApplyMobKill::dispatch($this->userId, $this->mobId)
                ->delay(now()->addSeconds($timeToKill));
        } else { //not enough hp
            //stop the fight.
            //TODO zelf de fight 'completen' en verwijderen met een knop ipv auto delete
            $fight->delete();
        }
    }
}
