<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('settlement_allocations');
        Schema::create('settlement_allocations', function (Blueprint $table) {
            $table->id();
			$table->string('invoice_number')->nullable();
			$table->integer('money_payment_id');
			$table->foreign('money_payment_id')->references('id')->on('money_payments');
			$table->unsignedBigInteger('contract_id')->nullable();
			$table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
			
			$table->unsignedBigInteger('partner_id')->nullable();
			$table->foreign('partner_id')->references('id')->on('partners')->cascadeOnDelete();
			
			$table->decimal('allocation_amount',14,2)->default(0);
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
        Schema::dropIfExists('settlement_allocations');
    }
}
