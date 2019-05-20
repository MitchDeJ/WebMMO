<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Func extends Model
{
    public static function validAmount($a) {
        if (!is_numeric($a))
            return false;

        if($a < 0)
            return false;

        return true;
    }
}
