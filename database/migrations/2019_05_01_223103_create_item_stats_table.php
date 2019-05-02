<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();

            $table->integer('melee');
            $table->integer('melee_defence');

            $table->integer('ranged');
            $table->integer('ranged_defence');

            $table->integer('magic');
            $table->integer('magic_defence');

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
        Schema::dropIfExists('item_stats');
    }
}
