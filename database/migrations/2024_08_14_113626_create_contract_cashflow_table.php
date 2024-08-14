<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractCashflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('contract_cashflow', function (Blueprint $table) {
        //     $table->id();
		// 	$table->string('invoice_number')->nullable();
		// 	$table->unsignedBigInteger('model_id')->comment('اما يكون money_received_id , money_payment_id , cash_expense_id');
		// 	$table->string('model_type')->comment('هنا هنحدد النوع وليكن مثلا MoneyPayment::class');
		// 	$table->unsignedBigInteger('customer_contract_id')->nullable();
		// 	$table->foreign('customer_contract_id')->references('id')->on('contracts')->cascadeOnDelete();
		// 	$table->unsignedBigInteger('supplier_contract_id')->nullable();
		// 	$table->foreign('supplier_contract_id')->references('id')->on('contracts')->cascadeOnDelete();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('contract_cashflow');
    }
}
