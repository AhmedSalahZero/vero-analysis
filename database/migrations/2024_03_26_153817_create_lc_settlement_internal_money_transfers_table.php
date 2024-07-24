<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLcSettlementInternalMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_settlement_internal_money_transfers', function (Blueprint $table) {
            $table->id();
			$table->string('type')->nullable();
			$table->date('transfer_date')->nullable()->comment('هو التاريخ اللي اللي هيتم فيه العميله ');
			$table->unsignedInteger('transfer_days')->comment('عدد الايام المتوقع فيها اتمام هذه العمليه');
			$table->integer('from_bank_id')->nullable();
			$table->foreign('from_bank_id')->references('id')->on('financial_institutions')->cascadeOnDelete();
			$table->bigInteger('from_account_type_id',false,true)->nullable();
			$table->foreign('from_account_type_id','qqq2')->references('id')->on('account_types')->nullOnDelete();
			$table->string('from_account_number')->nullable();
			$table->string('currency')->nullable();
			
			$table->unsignedBigInteger('to_letter_of_credit_issuance_id')->nullable();
			$table->foreign('to_letter_of_credit_issuance_id','qqq3')->references('id')->on('letter_of_credit_issuances')->cascadeOnDelete();
			
			
			$table->decimal('amount',14,2)->comment('مقدار مبلغ التحويل')->default(0);
		
			
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
        Schema::dropIfExists('lc_settlement_internal_money_transfers');
    }
}
