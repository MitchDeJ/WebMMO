<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //add all items to the database
        $this->call(UserSeeder::class);
        $this->call(ItemSeeder::class);
    }
}
