<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLcSettlementInternalMoneyTransferIdToCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            $table->unsignedBigInteger('lc_settlement_internal_money_transfer_id')->after('internal_money_transfer_id')->nullable();
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
