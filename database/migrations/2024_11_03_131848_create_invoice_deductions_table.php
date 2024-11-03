<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_deductions', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('invoice_id');
			$table->string('invoice_type');
			$table->unsignedBigInteger('deduction_id');
			$table->decimal('amount',14,2)->comment('deduction amount');
			$table->date('date');
			$table->unsignedBigInteger('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_deductions');
    }
}
