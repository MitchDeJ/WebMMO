<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Skill;
use App\Constants;
use App\InventorySlot;

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
        for($i=1; $i<=28; $i+=1) {
            DB::table('inventory_slots')->insert([
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
            'slot' => $i,
            'item_id' => null,
            'amount' => 0
        ]);
        // give tools
        $inv = InventorySlot::getInstance();
        $inv->addItem(1, 1, 1);
        $inv->addItem(1, 2, 1);
        $inv->addItem(1, 13, 1);


    }
}
