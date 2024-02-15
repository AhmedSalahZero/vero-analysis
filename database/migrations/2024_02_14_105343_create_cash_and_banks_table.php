<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashAndBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_and_banks', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('balance')->nullable();
            $table->date('date')->nullable();
            $table->unsignedInteger('financial_plan_id');
            $table->unsignedInteger('company_id');
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('cash_and_banks');
    }
}
