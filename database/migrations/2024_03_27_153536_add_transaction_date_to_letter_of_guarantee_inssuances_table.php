<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionDateToLetterOfGuaranteeInssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
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
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
            //
        });
    }
}
