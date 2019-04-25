<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false; //add this when we dont need the timestamps in our database

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'icon', 'stackable'
    ];

    public function getName($id) {
        $item = Item::where('id', $id)->get()->first();
        $name = $item->name;
        return $name;
    }

    public function getDescription($id) {
        $item = Item::where('id', $id)->get()->first();
        $desc = $item->description;
        return $desc;
    }

    public static function isStackable($id) {
        $item = Item::where('id', $id)->get()->first();
        $result = $item->stackable;
        return $result;
    }

    public function getIconPath($id) {

        //return empty slot if item is null
        if ($id == null)
            return '/img/items/empty.png';

        $item = Item::where('id', $id)->get()->first();
        $icon = $item->icon;
        return "/img/items/".$icon.'.png';
    }

    public function getItemCount() {
        return Item::count();
    }
}
