<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('skill_id')->unsigned();
            $table->integer('xp_amount');
            $table->float('success_chance');
            $table->integer('delay');
            $table->integer('tool_item')->unsigned()->nullable()->default(null);
            $table->integer('req_item')->unsigned()->nullable()->default(null);
            $table->integer('req_item_amount');
            $table->integer('req_item_2')->unsigned()->nullable()->default(null);
            $table->integer('req_item_2_amount')->nullable()->default(null);
            $table->integer('product_item')->unsigned()->nullable()->default(null);
            $table->integer('product_item_amount');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->onDelete('cascade');
            $table->foreign('tool_item')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->foreign('req_item')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->foreign('req_item_2')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->foreign('product_item')
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
        Schema::dropIfExists('skill_actions');
    }
}
