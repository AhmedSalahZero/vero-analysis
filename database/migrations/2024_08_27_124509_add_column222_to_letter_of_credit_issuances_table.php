<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumn222ToLetterOfCreditIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_credit_issuances', function (Blueprint $table) {
            $table->string('lc_cash_cover_currency')->nullable();
			$table->decimal('amount_in_main_currency',14,2)->nullable();
			$table->decimal('exchange_rate',14,2)->nullable();
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
