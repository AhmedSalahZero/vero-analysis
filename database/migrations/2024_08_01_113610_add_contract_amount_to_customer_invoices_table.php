<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractAmountToCustomerInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_invoices', function (Blueprint $table) {
            $table->decimal('contract_amount',14,2)->after('is_canceled')->nullable()->default(0);
            $table->string('contract_name')->after('is_canceled')->nullable();
            $table->string('contract_code')->after('is_canceled')->nullable();
            $table->date('contract_date')->after('is_canceled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_invoices', function (Blueprint $table) {
            //
        });
    }
}
