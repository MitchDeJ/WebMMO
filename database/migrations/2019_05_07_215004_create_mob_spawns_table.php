<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobSpawnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mob_spawns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mob_id')->unsigned();
            $table->integer('area_id')->unsigned();

            $table->foreign('mob_id')
                ->references('id')
                ->on('mobs')
                ->onDelete('cascade');

            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mob_spawns');
    }
}
