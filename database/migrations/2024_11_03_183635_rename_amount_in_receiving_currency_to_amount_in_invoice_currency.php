<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAmountInReceivingCurrencyToAmountInInvoiceCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received', function (Blueprint $table) {
            $table->renameColumn('amount_in_receiving_currency','amount_in_invoice_currency');
        });
		Schema::table('money_payments', function (Blueprint $table) {
            $table->renameColumn('amount_in_paying_currency','amount_in_invoice_currency');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receiving_currency_to_amount_in_invoice_currency', function (Blueprint $table) {
            //
        });
    }
}
