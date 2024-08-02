<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditOutgoingTransferNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('outgoing_transfers',function(Blueprint $table){
			$table->integer('money_payment_id')->nullable()->change();
		});
		Schema::table('payable_cheques',function(Blueprint $table){
			$table->integer('money_payment_id')->nullable()->change();
		});
		
		Schema::table('cash_payments',function(Blueprint $table){
			$table->integer('money_payment_id')->nullable()->change();
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
