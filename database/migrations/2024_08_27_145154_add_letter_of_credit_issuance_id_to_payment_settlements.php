<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLetterOfCreditIssuanceIdToPaymentSettlements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settlements', function (Blueprint $table) {
			if(!Schema::hasColumn('payment_settlements','letter_of_credit_issuance_id')){
				$table->unsignedBigInteger('letter_of_credit_issuance_id')->after('cash_expense_id');
			}
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_settlements', function (Blueprint $table) {
            //
        });
    }
}
