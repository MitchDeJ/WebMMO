<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
    }
}
