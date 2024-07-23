<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLcOverdraftWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_overdraft_withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lc_overdraft_bank_statement_id')->index('lc_overdrafts_identifier');
            $table->unsignedBigInteger('lc_issuance_id');
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
            $table->foreign(['lc_overdraft_bank_statement_id'], 'lc_overdrafts_identifier')->references(['id'])->on('lc_overdraft_bank_statements')->onUpdate('NO ACTION')->onDelete('CASCADE');
			
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
        Schema::dropIfExists('lc_overdraft_withdrawals');
    }
}
