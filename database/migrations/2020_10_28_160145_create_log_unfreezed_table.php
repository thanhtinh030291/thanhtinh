<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogUnfreezedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_unfreezed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('claim_id');
            $table->string('cl_no')->nullable();
            $table->string('reason')->nullable();
            $table->string('desc')->nullable();
            $table->integer('created_user');
            $table->integer('updated_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_unfreezed');
    }
}
