<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentEnToCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['current_account_bank_statements','clean_overdraft_bank_statements','fully_secured_overdraft_bank_statements','overdraft_against_assignment_of_contract_bank_statements','overdraft_against_commercial_paper_bank_statements'] as $tableName){
			Schema::table($tableName, function (Blueprint $table) {
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
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
