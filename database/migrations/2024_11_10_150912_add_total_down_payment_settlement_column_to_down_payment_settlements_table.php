<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalDownPaymentSettlementColumnToDownPaymentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['down_payment_settlements','down_payment_money_payment_settlements'] as $tableName){
			Schema::table($tableName, function (Blueprint $table) {
				$table->decimal('total_down_payment_settlement',14,2)->default(0)->after('down_payment_amount');
				$table->decimal('down_payment_balance',14,2)->default(0)->after('total_down_payment_settlement');
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
