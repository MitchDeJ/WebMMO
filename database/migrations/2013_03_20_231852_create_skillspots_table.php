<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillspotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skillspots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('area_id');
            $table->unsignedInteger('skill_id');
            $table->integer('xp_amount');
            $table->unsignedInteger('item_id');
            $table->integer('cooldown'); //cooldown in seconds

            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade');

            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
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
        Schema::dropIfExists('skillspots');
    }
}
