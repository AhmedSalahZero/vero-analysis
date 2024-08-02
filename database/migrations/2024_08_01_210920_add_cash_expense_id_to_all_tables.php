<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashExpenseIdToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(getTableNames() as $tableName){
			if(Schema::hasColumn($tableName,'money_payment_id')){
				Schema::table($tableName,function(Blueprint $table){
					$table->unsignedBigInteger('cash_expense_id')->after('money_payment_id')->nullable();
				});
			}
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('all_tables', function (Blueprint $table) {
            //
        });
    }
}
