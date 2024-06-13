<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyOrSellCurrencyIdToOverdraftAgainstCommercialPapersBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overdraft_against_commercial_paper_bank_statements', function (Blueprint $table) {
			$table->unsignedBigInteger('buy_or_sell_currency_id')->after('internal_money_transfer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overdraft_against_commercial_paper_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
