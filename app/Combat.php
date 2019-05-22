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

    public static function getUserAttackRoll($userId) {
        $style = self::getUserAttackStyle($userId);
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return self::getUserMeleeAttackRoll($userId);
            case (Constants::$ATTACK_STYLE_RANGED):
                return self::getUserRangedAttackRoll($userId);
            case (Constants::$ATTACK_STYLE_MAGIC):
                return self::getUserMagicAttackRoll($userId);

            default:
                return self::getUserMeleeAttackRoll($userId);
        }
    }

    public static function getUserDefenceRoll($userId, $style) {
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return self::getUserMeleeDefenceRoll($userId);
            case (Constants::$ATTACK_STYLE_RANGED):
                return self::getUserRangedDefenceRoll($userId);
            case (Constants::$ATTACK_STYLE_MAGIC):
                return self::getUserMagicDefenceRoll($userId);

            default:
                return self::getUserMeleeDefencekRoll($userId);
        }
    }

    public static function getUserMax($userId) {
        $style = self::getUserAttackStyle($userId);
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return self::getUserMeleeMax($userId);
            case (Constants::$ATTACK_STYLE_RANGED):
                return self::getUserRangedMax($userId);
            case (Constants::$ATTACK_STYLE_MAGIC):
                return self::getUserMagicMax($userId);

            default:
                return self::getUserMeleeMax($userId);
        }
    }

    public static function getUserAttackStyle($userId) {
        $weapon = UserEquip::where('equip_slot', Constants::$EQUIP_WEAPON)
            ->where('user_id', $userId)->get()->first();
        if ($weapon) {
            $item = Item::find(1);
            $style = $item->getAttackStyle($weapon->item_id);
        } else {
            $style = Constants::$ATTACK_STYLE_MELEE; //default is melee
        }
        return $style;
    }

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

    public static function getMobAttackStyle($mobId) {
        $mob = Mob::where('id', $mobId)->get()->first();
        $style = $mob->attack_style;
        return $style;
    }

    public static function getMobAttackRoll($mobId) {
        $style = self::getMobAttackStyle($mobId);
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return self::getMobMeleeAttackRoll($mobId);
            case (Constants::$ATTACK_STYLE_RANGED):
                return self::getMobRangedAttackRoll($mobId);
            case (Constants::$ATTACK_STYLE_MAGIC):
                return self::getMobMagicAttackRoll($mobId);

            default:
                return self::getMobMeleeAttackRoll($mobId);
        }
    }

    public static function getMobDefenceRoll($mobId, $style) {
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return self::getMobMeleeDefenceRoll($mobId);
            case (Constants::$ATTACK_STYLE_RANGED):
                return self::getMobRangedDefenceRoll($mobId);
            case (Constants::$ATTACK_STYLE_MAGIC):
                return self::getMobMagicDefenceRoll($mobId);

            default:
                return self::getMobMeleeDefenceRoll($mobId);
        }
    }

    public static function getMobMax($mobId) {
        $style = self::getMobAttackStyle($mobId);
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return self::getMobMeleeMax($mobId);
            case (Constants::$ATTACK_STYLE_RANGED):
                return self::getMobRangedMax($mobId);
            case (Constants::$ATTACK_STYLE_MAGIC):
                return self::getMobMagicMax($mobId);

            default:
                return self::getMobMeleeMax($mobId);
        }
    }

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
     * Accuracy calculations
     */
    public static function getUserAccuracy($userId, $mobId) {
        $user_att = Combat::getUserAttackRoll($userId);
        $mob_def = Combat::getMobDefenceRoll($mobId, self::getUserAttackStyle($userId));
        $accuracy = 0;

        if ($user_att > $mob_def) {
            $accuracy = 1 - ($mob_def+2) / (2*($user_att+1));
        } else {
            $accuracy = $user_att / (2*($mob_def+1));
        }

        return $accuracy;
    }

    public static function getMobAccuracy($userId, $mobId) {
        $mob_att = Combat::getMobAttackRoll($mobId);
        $user_def = Combat::getUserDefenceRoll($userId, self::getMobAttackStyle($mobId));
        $accuracy = 0;

        if ($mob_att > $user_def) {
            $accuracy = 1 - ($user_def+2) / (2*($mob_att+1));
        } else {
            $accuracy = $mob_att / (2*($user_def+1));
        }

        return $accuracy;
    }

    /*
     * mob fight calculations
     *
     */

    public static function getUserAverageDamage($userId, $mobId) {
        return Combat::getUserAccuracy($userId, $mobId) * (Combat::getUserMax($userId) / 2);
    }

    public static function getMobAverageDamage($mobId, $userId) {
        return Combat::getMobAccuracy($mobId, $userId) * (Combat::getMobMax($mobId) / 2);
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


    /*for granting xp*/
    public static function getSkillForStyle($style) {
        switch($style) {
            case (Constants::$ATTACK_STYLE_MELEE):
                return Constants::$MELEE;
            case (Constants::$ATTACK_STYLE_RANGED):
                return Constants::$RANGED;
            case (Constants::$ATTACK_STYLE_MAGIC):
                return Constants::$MAGIC;

            default:
                return Constants::$MELEE;
        }
    }
}
