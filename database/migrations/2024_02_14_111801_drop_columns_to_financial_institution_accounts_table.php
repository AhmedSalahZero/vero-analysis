<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsToFinancialInstitutionAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_institutions', function (Blueprint $table) {
            $table->dropColumn('iban_code');
            $table->dropColumn('current_account_number');
			
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
