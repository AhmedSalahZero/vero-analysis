<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyOrSellCurrencyIdToFullySecuredOverdraftBankSatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fully_secured_overdraft_bank_statements', function (Blueprint $table) {
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
        Schema::table('fully_secured_overdraft_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
