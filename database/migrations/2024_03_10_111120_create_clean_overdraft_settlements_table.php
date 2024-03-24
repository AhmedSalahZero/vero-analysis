<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleanOverdraftSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clean_overdraft_settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clean_overdraft_bank_statement_id');
            $table->foreign('clean_overdraft_bank_statement_id','clean_overdrafts_s_identifier')->references('id')->on('clean_overdraft_bank_statements')->cascadeOnDelete();
			
			$table->unsignedBigInteger('clean_overdraft_withdrawal_id');
            $table->foreign('clean_overdraft_withdrawal_id','clean_overdraft_with_s_identifier')->references('id')->on('clean_overdraft_withdrawals')->cascadeOnDelete();
			
            $table->unsignedBigInteger('clean_overdraft_id');
            $table->unsignedBigInteger('company_id');
            // $table->date('withdrawal_date');
            // $table->decimal('withdrawal_amount',14,2)->default(0);
            $table->decimal('settlement_amount',14,2)->default(0);
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
        Schema::dropIfExists('clean_overdraft_settlements');
    }
}
