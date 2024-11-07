<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceIdToSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->nullable()->after('invoice_number');
        });
		DB::table('settlements')->get()->each(function($settlementStd){
			$invoice = DB::table('customer_invoices')->where('invoice_number',$settlementStd->invoice_number)->first();
			DB::table('settlements')->where('id',$settlementStd->id)->update([
				'invoice_id'=>$invoice ? $invoice->id : null
			]);
		});
		Schema::table('settlements', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlements', function (Blueprint $table) {
            //
        });
    }
}
