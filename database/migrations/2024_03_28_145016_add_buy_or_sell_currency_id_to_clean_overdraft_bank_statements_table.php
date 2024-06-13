<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyOrSellCurrencyIdToCleanOverdraftBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clean_overdraft_bank_statements', function (Blueprint $table) {
            $table->unsignedBigInteger('buy_or_sell_currency_id')->after('money_received_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clean_overdraft_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
