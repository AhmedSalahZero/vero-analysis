<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBalanceAmountToFinancialInstitutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_institutions', function (Blueprint $table) {
            $table->dropColumn('main_currency');
            $table->dropColumn('balance_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_institutions', function (Blueprint $table) {
            //
        });
    }
}
