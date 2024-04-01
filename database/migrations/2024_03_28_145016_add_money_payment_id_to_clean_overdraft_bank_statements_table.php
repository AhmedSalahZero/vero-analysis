<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoneyPaymentIdToCleanOverdraftBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clean_overdraft_bank_statements', function (Blueprint $table) {
            $table->unsignedBigInteger('money_payment_id')->after('money_received_id')->nullable();
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
