<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomAndBoardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_and_boards', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('name');
            $table->increments('code_claim');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->integer('created_user');
            $table->integer('updated_user');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('room_and_boards');
    }
}
