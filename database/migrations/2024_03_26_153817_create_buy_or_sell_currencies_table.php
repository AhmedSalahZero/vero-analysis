<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyOrSellCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_or_sell_currencies', function (Blueprint $table) {
            $table->id();
			// common between all
			$table->string('type')->nullable();
			$table->date('transaction_date')->nullable()->comment('هو التاريخ اللي اللي هيتم فيه العميله ');
			$table->string('currency_to_sell')->nullable();
			$table->string('currency_to_buy')->nullable();
			$table->decimal('currency_to_sell_amount',14,2)->nullable();
			$table->decimal('exchange_rate',14,4)->nullable();
			$table->decimal('currency_to_buy_amount',14,2)->nullable();
			
			// common between bank to bank and bank to safe 
		
			$table->integer('from_bank_id')->nullable();
			$table->foreign('from_bank_id')->references('id')->on('financial_institutions')->cascadeOnDelete();
			$table->bigInteger('from_account_type_id',false,true)->nullable();
			$table->foreign('from_account_type_id')->references('id')->on('account_types')->nullOnDelete();
			$table->string('from_account_number')->nullable();

			
			//  bank to bank 
			$table->unsignedBigInteger('to_bank_id')->comment('بنوكي');
			$table->bigInteger('to_account_type_id',false,true)->nullable();
			$table->foreign('to_account_type_id')->references('id')->on('account_types')->nullOnDelete();
			$table->string('to_account_number')->nullable();
			//  bank to safe 
			$table->unsignedBigInteger('to_branch_id')->nullable();
			//  safe to bank 
			$table->unsignedBigInteger('from_branch_id')->nullable();
			
			// $table->unsignedBigInteger('to_bank_id')->comment('بنوكي');
			// $table->bigInteger('to_account_type_id',false,true)->nullable();
			// $table->foreign('to_account_type_id')->references('id')->on('account_types')->nullOnDelete();
			// $table->string('to_account_number')->nullable();
			
			// safe to safe
			// $table->unsignedBigInteger('from_branch_id')->nullable();
			// $table->unsignedBigInteger('to_branch_id')->nullable();
			
			$table->unsignedBigInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();
			
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
        Schema::dropIfExists('buy_or_sell_currencies');
    }
}
