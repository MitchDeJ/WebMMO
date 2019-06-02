<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constants extends Model
{
    public static $EQUIP_HELM = 0;
    public static $EQUIP_BODY = 1;
    public static $EQUIP_LEGS = 2;
    public static $EQUIP_WEAPON = 3;
    public static $EQUIP_SHIELD = 4;
    public static $EQUIP_AMULET = 5;
    public static $EQUIPS_TOTAL = 6;

    public static $MELEE = 1;
    public static $RANGED = 2;
    public static $MAGIC = 3;
    public static $HP = 4;
    public static $DEFENCE = 5;
    public static $WOODCUTTING = 6;
    public static $FISHING = 7;
    public static $COOKING = 8;
    public static $CRAFTING = 9;

    public static $ATTACK_STYLE_MELEE = 1;
    public static $ATTACK_STYLE_RANGED = 2;
    public static $ATTACK_STYLE_MAGIC = 3;

    public static $XP_PER_DAMAGE = 4;

    public static $JOB_PROCESS_DELAY = 2000;

    public static $COOLDOWN_SKILLING = 1;

    public static $MAX_LISTINGS = 4;

    public static $PLAYERS_PER_PAGE = 10;

}
