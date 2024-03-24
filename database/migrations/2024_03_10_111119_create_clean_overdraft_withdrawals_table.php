<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleanOverdraftWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clean_overdraft_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clean_overdraft_bank_statement_id');
            $table->foreign('clean_overdraft_bank_statement_id','clean_overdrafts_identifier')->references('id')->on('clean_overdraft_bank_statements')->cascadeOnDelete();
            $table->unsignedBigInteger('clean_overdraft_id');
            $table->unsignedBigInteger('company_id');
            // $table->date('withdrawal_date')->comment('هو نفسه التاريخ اللي موجود في ال bank statement -> date');
            // $table->decimal('withdrawal_amount',14,2)->default(0);
            $table->integer('max_settlement_days')->default(0);
            $table->date('due_date')->comment('تاريخ الاستحقاق وهو عباره عن جدول التاريخ 
			date
			من جدول ال 
			bank statement
			زائد ال
			max_settlement_days
			');
            $table->decimal('settlement_amount',14,2)->default(0);
            $table->decimal('net_balance',14,2)->default(0);
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
        Schema::dropIfExists('clean_overdraft_withdrawals');
    }
}
