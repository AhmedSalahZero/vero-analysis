<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// 2024_03_27_153536_add_transaction_date_to_letter_of_credit__table
class AddTransactionDateToLetterOfCreditInssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_credit_issuances', function (Blueprint $table) {
			$table->date('transaction_date')->after('transaction_name')->nullable();
			$table->string('transaction_reference')->after('transaction_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_credit_issuances', function (Blueprint $table) {
            //
        });
    }
}
