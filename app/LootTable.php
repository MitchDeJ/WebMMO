<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LootTable extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
       'table_id', 'mob_id'
    ];

    public function getMaxWeight() {
        $drops = LootTableDrop::where('table_id', $this->table_id)->get();
        $max = 0;
        foreach($drops as $drop) {
            $max += $drop->weight;
        }
        return $max;
    }

    public function getDrop() {
        $max = $this->getMaxWeight();
        $drops = LootTableDrop::where('table_id', $this->table_id)->get();

        $num = random_int(0, $max);

        $range = 0;
        $lastrange = 0;

        foreach($drops as $drop) {
            $lastrange = $range;
            $range += $drop->weight;

            if ($num >= $lastrange && $num <= $range) {
                $result = array();
                $amount = random_int($drop->min_amount, $drop->max_amount);
                $result['item_id'] = $drop->item_id;
                $result['amount'] = $amount;
                return $result;
            }
        }

            return null;
    }

}
