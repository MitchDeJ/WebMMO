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

    public function getName($id)
    {
        $item = Item::where('id', $id)->get();
        if (count($item) == 0)
            return null;
        $item = $item->first();
        $name = $item->name;
        return $name;
    }

    public function getDescription($id)
    {
        $item = Item::where('id', $id)->get()->first();
        $desc = $item->description;
        return $desc;
    }

    public static function isStackable($id)
    {
        $item = Item::where('id', $id)->get();
        if (count($item) == 0)
            return null;
        $item = $item->first();
        $result = $item->stackable;
        return $result;
    }

    public function getIconPath($id)
    {

        //return empty slot if item is null
        if ($id == null)
            return '/img/items/empty.png';

        $item = Item::where('id', $id)->get()->first();
        $icon = $item->icon;
        return "/img/items/" . $icon . '.png';
    }

    public static function getItemCount()
    {
        return Item::count();
    }

    public function getEquipSlot($id)
    {
        switch ($id) {

            //helmets
            case 5: //standard helm
                return Constants::$EQUIP_HELM;
            //bodies
            case 6: //standard body
                return Constants::$EQUIP_BODY;
            //legs
            case 7: //standard legs
                return Constants::$EQUIP_LEGS;
            //weapons
            case 8: // standard sword
            case 16: //standard bow
            case 19: //dark bow
                return Constants::$EQUIP_WEAPON;
            //shields
            case 9: //standard shield
                return Constants::$EQUIP_SHIELD;
            //amulets
            case 10: // standard amulet
                return Constants::$EQUIP_AMULET;

            default:
                return -1;
        }
    }

    public function getAttackStyle($id) {
        switch($id) {
            case 8://standard sword
                return Constants::$ATTACK_STYLE_MELEE;
            case 16: // standard bow
            case 19: // dark bow
                return Constants::$ATTACK_STYLE_RANGED;

            default:
                return Constants::$ATTACK_STYLE_MELEE;
        }
    }

    public function getHealAmount($id) {
        switch($id) {
            case 11: //apple
                return 5;
            case 12: //cooked fish
                return 7;
            default:
                return -1;
        }
    }

    public function isFood($id) {
        if ($this->getHealAmount($id) >= 0)
            return true;

        return false;
    }

    public function isRangedAmmo($id) {
        switch($id) {
            case 18:
                return true;
        }
        return false;
    }


    public function isMarketable($id) {
        switch($id) {
            case null:
                return false;
            case 17:
                return false;

            default:
                return true;
        }
    }

    public function getSelfEquipSlot() {
        return $this->getEquipSlot($this->id);
    }
}
