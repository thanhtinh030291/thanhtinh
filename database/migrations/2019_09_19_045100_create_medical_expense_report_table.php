<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalExpenseReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_expense_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content');
            $table->integer('unit_price');
            $table->integer('quantity');
            $table->integer('amount');
            $table->integer('is_deleted')->default('0');
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
        Schema::dropIfExists('medical_expense_report');
    }
}
