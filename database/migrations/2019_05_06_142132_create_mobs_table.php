<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('melee');
            $table->integer('ranged');
            $table->integer('magic');
            $table->integer('defence');
            $table->integer('hitpoints');
            $table->integer('attack_speed');
            $table->integer('attack_style');
            $table->integer('respawn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobs');
    }
}
