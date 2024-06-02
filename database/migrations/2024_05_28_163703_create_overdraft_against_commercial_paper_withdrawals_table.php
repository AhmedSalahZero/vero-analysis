<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverdraftAgainstCommercialPaperWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdraft_against_commercial_paper_withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('overdraft_against_commercial_paper_bank_statement_id')->index('overdraft_against_commercial_papers_identifier');
            $table->unsignedBigInteger('overdraft_against_commercial_paper_id');
            $table->unsignedBigInteger('company_id');
            $table->integer('max_settlement_days')->default(0);
            $table->date('due_date')->comment('تاريخ الاستحقاق وهو عباره عن جدول التاريخ 
			date
			من جدول ال 
			bank statement
			زائد ال
			max_settlement_days
			');
            $table->decimal('settlement_amount', 14)->default(0);
            $table->decimal('net_balance', 14)->default(0);
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
        Schema::dropIfExists('overdraft_against_commercial_paper_withdrawals');
    }
}
