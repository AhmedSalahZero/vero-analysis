<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_money_transfers', function (Blueprint $table) {
            $table->id();
			$table->date('transfer_date')->nullable()->comment('هو التاريخ اللي اللي هيتم فيه العميله ');
			$table->unsignedInteger('transfer_days')->comment('عدد الايام المتوقع فيها اتمام هذه العمليه');
			$table->integer('from_bank_id')->nullable();
			$table->foreign('from_bank_id')->references('id')->on('financial_institutions')->cascadeOnDelete();
			
			$table->integer('to_bank_id')->nullable();
			$table->foreign('to_bank_id')->references('id')->on('financial_institutions')->cascadeOnDelete();
			
			
			$table->decimal('amount',14,2)->comment('مقدار مبلغ التحويل')->default(0);
			$table->bigInteger('from_account_type_id',false,true)->nullable();
			$table->foreign('from_account_type_id')->references('id')->on('account_types')->nullOnDelete();
			$table->string('from_account_number')->nullable();
			$table->string('currency')->nullable();
			
			$table->bigInteger('to_account_type_id',false,true)->nullable();
			$table->foreign('to_account_type_id')->references('id')->on('account_types')->nullOnDelete();
			$table->string('to_account_number')->nullable();
			
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
        Schema::dropIfExists('internal_money_transfers');
    }
}
