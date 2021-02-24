<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtendClaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extend_claim', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cl_no')->nullable();
            $table->integer('claim_id');
            $table->integer('user')->default(1);
            $table->integer('notify')->default(0);
            $table->date('begin_day_renewal')->nullable();
            $table->date('end_day_renewal')->nullable();
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
        Schema::dropIfExists('extend_claim');
    }
}
