<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInternalMoneyTransferIdToCashInSafeStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_in_safe_statements', function (Blueprint $table) {
            $table->unsignedBigInteger('internal_money_transfer_id')->after('money_payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_in_safe_statements', function (Blueprint $table) {
            //
        });
    }
}
