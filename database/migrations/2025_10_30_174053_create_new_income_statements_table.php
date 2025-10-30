<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewIncomeStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->create('test_income_statements', function (Blueprint $table) {
        //     $table->id();
		// 	$table->json('revenues');
		// 	$table->json('oda_interests');
		// 	$table->json('corporate_taxes');
        //     $table->timestamps();
        // });
		//   Schema::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->create('test_cashflow_statements', function (Blueprint $table) {
        //     $table->id();
		// 	$table->json('cash_in');
		// 	$table->json('cash_out');
		// 	$table->json('oda_interests');
		// 	$table->json('corporate_taxes_payments');
        //     $table->timestamps();
        // });
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
