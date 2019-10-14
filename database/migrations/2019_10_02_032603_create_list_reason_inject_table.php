<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListReasonInjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_reason_inject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 500);
            $table->integer('created_user');
            $table->integer('updated_user');
            $table->timestamps();
            $table->integer('is_deleted')->default('0');
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
        Schema::dropIfExists('list_reason_inject');
    }
}
