<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCurrencyToDownPaymentsSettlementsTable extends Migration
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
				$table->string('currency')->nullable()->after('down_payment_balance');
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
