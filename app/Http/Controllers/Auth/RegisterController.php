<?php

namespace App\Http\Controllers\Auth;

use App\CombatFocus;
use App\User;
use App\Skill;
use App\Constants;
use App\UserSkill;
use App\InventorySlot;
use App\BankSlot;
use App\UserEquip;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
            'description' => 'user description',
            'title' => 0,
            'area_id' => 1,
            'account_created_at' =>  date("d-m-Y"),
            'remember_token' => 'remembertoken', //TODO
        ]);

        $skills = Skill::all();
        foreach ($skills as $skill) {
            UserSkill::create([
                'user_id' => $user->id,
                'skill_id' => $skill->id,
                'xp_amount' => 0,
            ]);
        }
        for ($i = 1; $i <= 28; $i += 1) {
            InventorySlot::create([
                'user_id' => $user->id,
                'slot' => $i,
                'item_id' => null,
                'amount' => 0
            ]);
        }

        //bank
        for($i=1; $i<=70; $i+=1) {
            BankSlot::create([
                'user_id' => $user->id,
                'slot' => $i,
                'item_id' => null,
                'amount' => 0
            ]);
        }

        for ($i = 0; $i < Constants::$EQUIPS_TOTAL; $i += 1) {
            UserEquip::create([
                'user_id' => $user->id,
                'equip_slot' => $i,
                'item_id' => null,
            ]);
        }

        CombatFocus::create([
            'user_id' => $user->id,
            'focus_type' => 1
        ]);

        return $user;
    }
}
