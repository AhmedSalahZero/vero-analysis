<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentEnToLetterOfGuaranteeStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['letter_of_guarantee_statements','letter_of_credit_statements'] as $tableName){
			Schema::table($tableName, function (Blueprint $table) {
				$table->string('comment_en')->after('end_balance')->nullable();
				$table->string('comment_ar')->after('end_balance')->nullable();
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
