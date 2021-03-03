<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifyDayRenewalToExtendClaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extend_claim', function (Blueprint $table) {
            //
            $table->date('notify_day_renewal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extend_claim', function (Blueprint $table) {
            //
            Schema::dropIfExists('notify_day_renewal');
        });
    }
}
