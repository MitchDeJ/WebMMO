<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $toTruncate = ['users', 'items']; //what tables do we need to truncate (empty) before seeding?

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //truncate tables
        foreach($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        //add all items to the database
        $this->call(UserSeeder::class);
        $this->call(ItemSeeder::class);
    }
}
