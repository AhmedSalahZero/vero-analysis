<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_payments', function (Blueprint $table) {
            $table->id();
			$table->integer('money_payment_id');
			$table->foreign('money_payment_id')->references('id')->on('money_payments')->cascadeOnDelete();
			$table->integer('delivery_branch_id')->nullable();
			$table->foreign('delivery_branch_id')->references('id')->on('branch')->nullOnDelete();
			$table->string('receipt_number')->nullable();
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
        Schema::dropIfExists('cash_payments');
    }
}
