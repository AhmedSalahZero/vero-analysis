<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStartSettlementFromBankStatementIdToCleanOverdraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clean_overdrafts', function (Blueprint $table) {
			$table->dropColumn('start_settlement_from_bank_statement_id');
			$table->date('start_settlement_from_bank_statement_date')->nullable();
            // $table->renameColumn('start_settlement_from_bank_statement_id','paid_amount_in_main_currency')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clean_overdrafts', function (Blueprint $table) {
            //
        });
    }
}
