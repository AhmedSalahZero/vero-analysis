<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDownPaymentTypeColumnToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['money_received','money_payments'] as $tableName){
			Schema::table($tableName, function (Blueprint $table) {
				$table->string('down_payment_type')->after('money_type')->nullable();
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
        Schema::table('money_received', function (Blueprint $table) {
            //
        });
    }
}
