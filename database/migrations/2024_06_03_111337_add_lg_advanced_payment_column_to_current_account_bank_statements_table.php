<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLgAdvancedPaymentColumnToCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
			$table->unsignedBigInteger('lg_advanced_payment_history_id')->after('letter_of_guarantee_issuance_id')->nullable();
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
