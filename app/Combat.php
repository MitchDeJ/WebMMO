<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserSkill;
use App\ItemStats;
use App\Mob;

class Combat extends Model
{ // https://jsfiddle.net/qsthw8ju/6/ for formulas

    /*
     * User functions
     */

    public static function getUserMeleeAttackRoll($userId) {
    $skill = UserSkill::where('user_id', $userId)
        ->where('skill_id', Constants::$MELEE)->get()->first();
    $level = $skill->levelForXp($skill->xp_amount);
    $bonus = ItemStats::getStatTotal($userId, 'melee');

    return $level * ($bonus + 64);
}

    public static function getUserMeleeDefenceRoll($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$DEFENCE)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'melee_defence');

        return $level * ($bonus + 64);
    }

    public static function getUserRangedAttackRoll($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$RANGED)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'ranged');

        return $level * ($bonus + 64);
    }

    public static function getUserRangedDefenceRoll($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$DEFENCE)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'ranged_defence');

        return $level * ($bonus + 64);
    }

    public static function getUserMagicAttackRoll($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$MAGIC)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'magic');

        return $level * ($bonus + 64);
    }

    public static function getUserMagicDefenceRoll($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$DEFENCE)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'magic_defence');

        return $level * ($bonus + 64);
    }

    public static function getUserMeleeMax($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$MELEE)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'melee');

        return ceil(0.5 + $level * ($bonus+64) /640);
    }

    public static function getUserRangedMax($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$RANGED)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'ranged');

        return ceil(0.5 + $level * ($bonus+64) /640);
    }

    public static function getUserMagicMax($userId) {
        $skill = UserSkill::where('user_id', $userId)
            ->where('skill_id', Constants::$MAGIC)->get()->first();
        $level = $skill->levelForXp($skill->xp_amount);
        $bonus = ItemStats::getStatTotal($userId, 'magic');

        return ceil(0.5 + $level * ($bonus+64) /640);
    }

    /*
     * Mob Functions
     */

    public static function getMobMeleeAttackRoll($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->melee;

        return $level * (64);
    }

    public static function getMobMeleeDefenceRoll($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->defence;
        $bonus = $mob->melee;

        return $level * ($bonus + 64);
    }

    public static function getMobRangedAttackRoll($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->ranged;

        return $level * (64);
    }

    public static function getMobRangedDefenceRoll($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->defence;
        $bonus = $mob->ranged;

        return $level * ($bonus + 64);
    }

    public static function getMobMagicAttackRoll($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->magic;

        return $level * (64);
    }

    public static function getMobMagicDefenceRoll($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->defence;
        $bonus = $mob->magic;

        return $level * ($bonus + 64);
    }

    public static function getMobMeleeMax($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->melee;
        $bonus = ($mob->melee / 2);

        return ceil(0.5 + $level * ($bonus+64) /640);
    }

    public static function getMobRangedMax($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->ranged;
        $bonus = ($mob->ranged / 2);

        return ceil(0.5 + $level * ($bonus+64) /640);
    }

    public static function getMobMagicMax($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $level = $mob->magic;
        $bonus = ($mob->magic / 2);

        return ceil(0.5 + $level * ($bonus+64) /640);
    }

    /*
     * Attack speeds TODO use attack speed instead of always using '2'
     */

    public static function getUserAttackSpeed($userId) {
        return 2;
    }

    public static function getMobAttackSpeed($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        return $mob->attack_speed;
    }
    /*
     * Accuracy calculations TODO always uses melee accuracy
     */
    public static function getUserAccuracy($userId, $mobId) {
        $user_att = Combat::getUserMeleeAttackRoll($userId);
        $mob_def = Combat::getMobMeleeDefenceRoll($mobId);
        $accuracy = 0;

        if ($user_att > $mob_def) {
            $accuracy = 1 - ($mob_def+2) / (2*($user_att+1));
        } else {
            $accuracy = $user_att / (2*($mob_def+1));
        }

        return $accuracy;
    }

    public static function getMobAccuracy($userId, $mobId) {
        $mob_att = Combat::getMobMeleeAttackRoll($userId);
        $user_def = Combat::getUserMeleeDefenceRoll($mobId);
        $accuracy = 0;

        if ($mob_att > $user_def) {
            $accuracy = 1 - ($user_def+2) / (2*($mob_att+1));
        } else {
            $accuracy = $mob_att / (2*($user_def+1));
        }

        return $accuracy;
    }

    /*
     * mob fight calculations TODO always gets melee accuracy/max hit
     *
     */

    public static function getUserAverageDamage($userId, $mobId) {
        return Combat::getUserAccuracy($userId, $mobId) * (Combat::getUserMeleeMax($userId) / 2);
    }

    public static function getMobAverageDamage($mobId, $userId) {
        return Combat::getMobAccuracy($mobId, $userId) * (Combat::getMobMeleeMax($mobId) / 2);
    }

    public static function getHitsToKill($userId, $mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $mob_hp = $mob->hitpoints;

        return ceil($mob_hp / Combat::getUserAverageDamage($userId, $mobId));
    }

    public static function getTimeToKill($userId, $mobId) {
        return Combat::getHitsToKill($userId, $mobId) * Combat::getUserAttackSpeed($userId);
    }

    public static function getDamageTakenPerKill($userId, $mobId) {
        return (Combat::getTimeToKill($userId, $mobId) / Combat::getMobAttackSpeed($mobId)) * Combat::getMobAverageDamage($mobId, $userId);
    }

}
