<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReceivedAmountInMainCurrencyToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received', function (Blueprint $table) {
            $table->renameColumn('received_amount_in_main_currency','amount_in_receiving_currency');
        });
		
		Schema::table('money_payments', function (Blueprint $table) {
            $table->renameColumn('paid_amount_in_main_currency','amount_in_paying_currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('money_received', function (Blueprint $table) {
            //
        });
    }
}
