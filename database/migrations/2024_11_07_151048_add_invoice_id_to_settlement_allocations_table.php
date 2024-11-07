<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceIdToSettlementAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlement_allocations', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->after('invoice_number')->nullable();
        });
		DB::table('settlement_allocations')->get()->each(function($settlementAllocation){
			$supplierInvoice = DB::table('supplier_invoices')->where('invoice_number',$settlementAllocation->invoice_number)->first() ;
			if($supplierInvoice){
				DB::table('settlement_allocations')->where('id',$settlementAllocation->id)->update([
					'invoice_id'=>$supplierInvoice->id
				]);
				
			}
		});
		
		Schema::table('settlement_allocations', function (Blueprint $table) {
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
        Schema::table('settlement_allocations', function (Blueprint $table) {
            //
        });
    }
}
