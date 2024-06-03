<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLgAdvancedPaymentColumnToLetterOfGuaranteeStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_statements', function (Blueprint $table) {
			$table->unsignedBigInteger('lg_advanced_payment_history_id')->after('lg_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_guarantee_statements', function (Blueprint $table) {
            //
        });
    }
}
