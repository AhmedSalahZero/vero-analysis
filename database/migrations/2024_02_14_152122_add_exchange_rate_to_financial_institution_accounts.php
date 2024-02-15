<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExchangeRateToFinancialInstitutionAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_institution_accounts', function (Blueprint $table) {
            $table->renameColumn('balance_rate','interest_rate');
            $table->decimal('exchange_rate',5,2)->default(1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_institution_accounts', function (Blueprint $table) {
            //
        });
    }
}
