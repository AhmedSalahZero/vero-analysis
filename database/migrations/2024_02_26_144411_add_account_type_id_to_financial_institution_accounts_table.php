<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountTypeIdToFinancialInstitutionAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_institution_accounts', function (Blueprint $table) {
            $table->bigInteger('account_type_id',false,true)->after('financial_institution_id')->nullable();
			$table->foreign('account_type_id')->references('id')->on('account_types')->nullOnDelete();
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
