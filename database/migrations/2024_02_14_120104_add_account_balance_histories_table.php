<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountBalanceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('account_balance_histories', function (Blueprint $table) {
			$table->id();
			$table->integer('financial_institution_account_id');
			$table->foreign('financial_institution_account_id','account_foreign')->references('id')->on('financial_institution_accounts')->cascadeOnDelete()->cascadeOnUpdate();
			$table->date('start_date')->default(null)->nullable();
			$table->decimal('balance_rate',5,2)->default(0)->nullable();
			$table->decimal('min_balance',15,2)->default(0)->nullable();
		});
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
