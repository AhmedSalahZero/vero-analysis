<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashExpenseContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_expense_contract', function (Blueprint $table) {
            $table->id();
			$table->integer('cash_expense_id')->nullable();
			$table->foreign('cash_expense_id')->references('id')->on('cash_expenses')->cascadeOnDelete();
			$table->unsignedBigInteger('contract_id')->nullable();
			$table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
			$table->decimal('amount',14,2);
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
        Schema::dropIfExists('cash_expense_contract');
    }
}
