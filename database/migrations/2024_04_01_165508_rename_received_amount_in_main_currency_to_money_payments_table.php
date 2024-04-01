<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReceivedAmountInMainCurrencyToMoneyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_payments', function (Blueprint $table) {
            $table->renameColumn('received_amount_in_main_currency','paid_amount_in_main_currency')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('money_payments', function (Blueprint $table) {
            //
        });
    }
}
