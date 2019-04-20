<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('description');
            $table->integer('area_id')->unsigned();
            $table->string('avatar')->default('default.png');
            $table->string('account_created_at');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken(); // 'remember me' function

            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade');

//            $table->integer('clan_id')->nullable();
//            $table->foreign('clan_id')
//                ->references('id')
//                ->on('clans')
//                ->onDelete('cascade');
//            $table->integer('title_id')->nullable();
//            $table->foreign('title_id')
//                ->references('id')
//                ->on('titles')
//                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
