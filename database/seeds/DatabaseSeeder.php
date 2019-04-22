<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    //what tables do we need to truncate (empty) before seeding?
    protected $toTruncate = ['users', 'items', 'areas', 'skills', 'skillspots', 'user_skills'];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //disable foreign key checks so we can still empty certain tables

        //truncate tables
        foreach($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //enable it again
        $this->call(ItemSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(SkillSpotSeeder::class);
        $this->call(UserSeeder::class);
    }
}
