<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutstandingWithdrawalDateToCleanOverdraftBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['clean_overdraft_bank_statements','fully_secured_overdraft_bank_statements','lc_overdraft_bank_statements','overdraft_against_assignment_of_contract_bank_statements','overdraft_against_commercial_paper_bank_statements'] as $tableName){
			Schema::table($tableName, function (Blueprint $table) {
				$table->date('outstanding_withdrawal_date')->nullable();
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
        Schema::table('clean_overdraft_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
