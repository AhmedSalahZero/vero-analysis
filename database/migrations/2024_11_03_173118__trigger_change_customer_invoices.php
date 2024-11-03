<?php

use App\Models\CustomerInvoice;
use App\Models\SupplierInvoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerChangeCustomerInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(CustomerInvoice::get() as $customerInvoice){
			$customerInvoice->update([
				'updated_at'=>now()
			]);
		}
		foreach(SupplierInvoice::get() as $supplierInvoice){
			$supplierInvoice->update([
				'updated_at'=>now()
			]);
		}
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
