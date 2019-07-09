<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Skill;
use App\Constants;
use App\InventorySlot;
use App\BankSlot;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.nl',
            'email_verified_at' => now(),
            'description' => 'kanker binkie',
            'area_id' => 1,
            'title' => 0,
            'account_created_at' => now(),
            'password' => bcrypt("admin"),
            'remember_token' => Str::random(10),
        ]);
        $skills = Skill::all();
        foreach($skills as $skill) {
            DB::table('user_skills')->insert([
                'user_id' => '1',
                'skill_id' => $skill->id,
                'xp_amount' => 0,
            ]);
        }
        //invy
        for($i=1; $i<=28; $i+=1) {
            DB::table('inventory_slots')->insert([
                'user_id' => '1',
                'slot' => $i,
                'item_id' => null,
                'amount' => 0
            ]);
        }

        //bank
        for($i=1; $i<=70; $i+=1) {
            DB::table('bank_slots')->insert([
                'user_id' => '1',
                'slot' => $i,
                'item_id' => null,
                'amount' => 0
            ]);
        }


        for($i=0; $i < Constants::$EQUIPS_TOTAL; $i+=1) {
            DB::table('user_equips')->insert([
                'user_id' => '1',
                'equip_slot' => $i,
                'item_id' => null,
            ]);
        }

        DB::table('combat_focus')->insert([
            'user_id' => '1',
            'focus_type' => Constants::$FOCUS_PRIMARY
        ]);
        // give tools
        $inv = InventorySlot::getInstance();
        $inv->addItem(1, 1, 1);
        $inv->addItem(1, 2, 1);
        $inv->addItem(1, 13, 1);
        $inv->addItem(1, 20, 1);
        $inv->addItem(1, 24, 1);
        $inv->addItem(1, 25, 1);


    }
}
