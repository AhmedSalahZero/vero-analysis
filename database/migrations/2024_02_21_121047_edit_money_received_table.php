<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received',function(Blueprint $table){
			$table->renameColumn('money_type','type');
			$table->dropColumn('receiving_branch_id');
			$table->dropColumn('receipt_number');
			$table->dropColumn('receipt_bank_id');
			$table->dropColumn('drawee_bank_id');
			$table->dropColumn('receiving_bank_id');
			$table->dropColumn('cheque_due_date');
			$table->dropColumn('cheque_deposit_date');
			$table->dropColumn('cheque_number');
			$table->dropColumn('cheque_drawl_bank_id');
			$table->dropColumn('account_number_for_cheques_collection');
			$table->dropColumn('cheque_account_balance');
			$table->dropColumn('cheque_expected_collection_date');
			$table->dropColumn('cheque_clearance_days');
			$table->dropColumn('cheque_status');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
