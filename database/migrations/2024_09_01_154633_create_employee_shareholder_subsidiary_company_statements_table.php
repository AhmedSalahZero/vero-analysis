<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeShareholderSubsidiaryCompanyStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['employee_statements','shareholder_statements','subsidiary_company_statements'] as $tableName){
			Schema::create($tableName, function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('company_id');
				$table->string('currency_name');
				$table->boolean('is_debit')->default(false);
				$table->boolean('is_credit')->default(true);
				$table->date('date')->nullable();
				$table->unsignedBigInteger('partner_id');
				$table->foreign('partner_id')->references('id')->on('partners')->cascadeOnDelete();
				$table->unsignedBigInteger('money_received_id')->nullable();
				$table->unsignedBigInteger('money_payment_id')->nullable();
				$table->dateTime('full_date')->nullable();
				$table->decimal('beginning_balance', 14)->default(0);
				$table->decimal('debit', 14)->default(0);
				$table->decimal('credit', 14)->default(0);
				$table->decimal('end_balance', 14)->default(0);
				$table->timestamps();
				$table->string('comment_en')->nullable();
				$table->string('comment_ar')->nullable();
			});
		}
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_statements');
    }
}
