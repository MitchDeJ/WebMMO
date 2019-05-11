<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LootTableDrop extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    protected $fillable = [
        'loot_table_id', 'item_id', 'min_amount', 'max_amount', 'weight'
    ];
}
