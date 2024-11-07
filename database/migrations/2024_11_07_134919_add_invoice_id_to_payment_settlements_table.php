<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceIdToPaymentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->nullable()->after('invoice_number');
        });
		DB::table('payment_settlements')->get()->each(function($settlementStd){
			$invoice = DB::table('supplier_invoices')->where('invoice_number',$settlementStd->invoice_number)->first();
			DB::table('payment_settlements')->where('id',$settlementStd->id)->update([
				'invoice_id'=>$invoice ? $invoice->id : null
			]);
		});
		Schema::table('payment_settlements', function (Blueprint $table) {
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
