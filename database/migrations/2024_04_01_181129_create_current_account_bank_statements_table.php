<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_account_bank_statements', function (Blueprint $table) {
			$table->id();
			// $table->string('type')->comment('وليكن مثلا beginning_balance,incoming_transfer,cheque_payment  , etc');
			$table->integer('financial_institution_account_id');
			$table->unsignedBigInteger('company_id');// i will not use foreign key here
			$table->unsignedBigInteger('money_received_id');// i will not use foreign key here
			$table->unsignedBigInteger('money_payment_id');// i will not use foreign key here
			
			$table->boolean('is_debit')->default(0);
			$table->boolean('is_credit')->default(1);


			$table->date('date')->nullable();
		
			$table->decimal('beginning_balance',14,2)->default(0);
			$table->decimal('debit',14,2)->default(0); 
			$table->decimal('credit',14,2)->default(0); 
			$table->decimal('end_balance',14,2)->default(0); 
			
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
        Schema::dropIfExists('cash_in_safe_statements');
    }
}
