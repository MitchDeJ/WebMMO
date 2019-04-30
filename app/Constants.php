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
}
