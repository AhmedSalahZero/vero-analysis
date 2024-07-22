<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns4ToCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
			$table->unsignedBigInteger('letter_of_credit_issuance_id')->after('letter_of_guarantee_issuance_id')->nullable();
        });
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
