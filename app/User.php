<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\UserDialogue;
use App\Dialogue;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false; //add this when we dont need the timestamps in our database
    private $processingEquip = false; //prevent unequip duping

    public function addFlag($flag) {
        if ($this->hasFlag($flag))
            return;

        UserFlag::create([
            'user_id' => $this->id,
            'flag' => $flag
        ]);
    }

    public function removeFlag($flag) {
        $flag = UserFlag::where('user_id', $this->id)
            ->where('flag', $flag)->get()->first();

        if (!$flag)
            return;

        $flag->delete();
    }

    public function hasFlag($flag) {
        $flag = UserFlag::where('user_id', $this->id)
            ->where('flag', $flag)->get()->first();

        if (!$flag)
            return false;

        return true;
    }

    public function getGP() {
        $inv = InventorySlot::getInstance();
        $gp = $inv->getItemCount($this->id, 17);
        return $gp;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'avatar', 'account_created_at', 'area_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function location() {
        return $this->hasOne('App\Area', 'id', 'area_id');
    }

    public function setDialogue($dId) {
        $dialogue = Dialogue::find($dId);

        $current = UserDialogue::where('user_id', $this->id)->get();
        if (count($current) == 0) {
            //create a new row.
            UserDialogue::create(array(
                'user_id' => $this->id,
                'dialogue_id' => $dialogue->id
            ));
        } else {
            //update existing row
            $current = $current->first();
            $current->dialogue_id = $dialogue->id;
            $current->save();
        }
    }

    public function getDialogue() {
        return UserDialogue::where('user_id', $this->id)->get()->first()->dialogue_id;
    }
}
