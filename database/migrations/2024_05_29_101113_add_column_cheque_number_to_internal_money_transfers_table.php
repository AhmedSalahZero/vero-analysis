<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnChequeNumberToInternalMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_money_transfers', function (Blueprint $table) {
			$table->string('cheque_number')->nullable()->after('to_account_number');
			$table->unsignedBigInteger('to_branch_id')->nullable()->after('cheque_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_money_transfers', function (Blueprint $table) {
            //
        });
    }
}
