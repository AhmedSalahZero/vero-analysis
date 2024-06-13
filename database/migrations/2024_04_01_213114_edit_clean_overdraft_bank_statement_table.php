<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCleanOverdraftBankStatementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('clean_overdraft_bank_statements', function (Blueprint $table) {
			
			$table->decimal('beginning_balance',14,2)->change();
			$table->decimal('debit',14,2)->change();
			$table->decimal('credit',14,2)->change();
			$table->decimal('end_balance',14,2)->change();
			$table->decimal('room',14,2)->change();
        });
		
		Schema::table('cash_in_safe_statements', function (Blueprint $table) {
			$table->decimal('beginning_balance',14,2)->change();
			$table->decimal('debit',14,2)->change();
			$table->decimal('credit',14,2)->change();
			$table->decimal('end_balance',14,2)->change();
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
