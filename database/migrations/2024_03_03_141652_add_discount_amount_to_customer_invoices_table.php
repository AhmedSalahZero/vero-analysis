<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountAmountToCustomerInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_invoices', function (Blueprint $table) {
            $table->decimal('discount_amount',14,2)->default(0);
            $table->decimal('discount_amount_in_main_currency',14,2)->default(0);
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
