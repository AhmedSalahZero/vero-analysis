<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToBeSetteledMaxWithinDaysColumnToCleanOverdraftBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('be_setteled_max_within_days_column_to_clean_overdraft_bank_statements', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('be_setteled_max_within_days_column_to_clean_overdraft_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
