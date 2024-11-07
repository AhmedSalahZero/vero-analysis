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
        // Schema::table('settlements', function (Blueprint $table) {
        //     $table->unsignedBigInteger('invoice_id')->nullable()->after('invoice_number');
        // });
		// DB::table('settlements')->each(function($settlementStd){
		// 	DB::table('settlements')->where('id',$settlementStd->id)->update([
		// 		'invoice_id'=>DB::table('customer_invoices')->where('invoice_number',$settlementStd->invoice_number)->first()->id
		// 	]);
		// });
		// Schema::table('settlements', function (Blueprint $table) {
        //     $table->dropColumn('invoice_number')->nullable()->after('invoice_number');
        // });
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
