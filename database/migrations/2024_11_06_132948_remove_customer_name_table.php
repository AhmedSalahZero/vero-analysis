<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCustomerNameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements',function(Blueprint $table){
			$table->dropColumn('customer_name');
		});
		Schema::table('money_received',function(Blueprint $table){
			$table->dropColumn('customer_name');
		});
		Schema::table('money_payments',function(Blueprint $table){
			$table->dropColumn('supplier_name');
		});
		Schema::table('payment_settlements',function(Blueprint $table){
			$table->dropColumn('supplier_name');
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
