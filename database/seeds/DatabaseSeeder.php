<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    //what tables do we need to truncate (empty) before seeding?
    protected $toTruncate = ['users', 'items', 'areas', 'skills', 'skillspots',
        'user_skills', 'npcs', 'spotrequirements', 'inventory_slots', 'user_equips',
        'item_stats', 'mobs', 'mob_spawns', 'mob_fights', 'loot_tables', 'loot_table_drops',
        'map_points', 'dialogues', 'dialogue_messages', 'area_objects', 'area_object_spawns',
        'shops', 'shop_items', 'news'];

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
        $this->call(NpcSeeder::class);
        $this->call(SkillSpotSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SpotRequirementSeeder::class);
        $this->call(ItemStatSeeder::class);
        $this->call(MobSeeder::class);
        $this->call(MobSpawnSeeder::class);
        $this->call(LootTableSeeder::class);
        $this->call(LootTableDropSeeder::class);
        $this->call(MapPointSeeder::class);
        $this->call(DialogueSeeder::class);
        $this->call(AreaObjectSeeder::class);
        $this->call(AreaObjectSpawnSeeder::class);
        $this->call(ShopSeeder::class);
    }
}
