<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialogueMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogue_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dialogue_id')->unsigned();
            $table->string('actor');
            $table->string('text');

            $table->foreign('dialogue_id')
                ->references('id')
                ->on('dialogues')
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
        Schema::dropIfExists('dialogue_messages');
    }
}
