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
        'name', 'description', 'icon'
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

    public function getIconPath($id) {
        $item = Item::where('id', $id)->get()->first();
        $icon = $item->icon;
        return "/img/items/".$icon.'.png';
    }

    public function getItemCount() {
        return Item::count();
    }
}
