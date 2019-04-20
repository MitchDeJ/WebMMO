<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $toTruncate = ['users', 'items', 'areas']; //what tables do we need to truncate (empty) before seeding?

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
        $this->call(AreaSeeder::class);
        $this->call(UserSeeder::class);
    }
}
