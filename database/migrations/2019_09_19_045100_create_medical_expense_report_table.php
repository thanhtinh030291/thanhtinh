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
            $table->string('id_claim')->nullable();
            $table->string('url_file')->nullable();
            $table->string('url_file_split')->nullable();
            $table->string('url_file_export')->nullable();
            $table->string('content')->nullable();
            $table->integer('unit_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('created_user')->nullable();
            $table->integer('updated_user')->nullable();
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
