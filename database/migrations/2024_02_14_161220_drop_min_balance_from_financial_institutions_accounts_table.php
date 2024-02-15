<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMinBalanceFromFinancialInstitutionsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_institution_accounts', function (Blueprint $table) {
            $table->dropColumn('min_balance');
            $table->dropColumn('interest_rate');
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
