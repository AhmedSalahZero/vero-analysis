<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownPaymentMoneyPaymentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('down_payment_money_payment_settlements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('sales_order_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('down_payment_amount')->nullable();
            $table->integer('money_payment_id')->nullable();
			$table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
			$table->foreign('sales_order_id')->references('id')->on('sales_orders')->cascadeOnDelete();
			$table->foreign('money_payment_id')->references('id')->on('money_payments')->cascadeOnDelete();
			$table->foreign('supplier_id')->references('id')->on('partners')->cascadeOnDelete();
            $table->integer('company_id')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('down_payment_money_payment_settlements');
    }
}
