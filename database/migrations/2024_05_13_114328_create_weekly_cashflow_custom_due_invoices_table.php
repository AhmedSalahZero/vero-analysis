<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyCashflowCustomDueInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_cashflow_custom_due_invoices', function (Blueprint $table) {
            $table->id();
			$table->integer('invoice_id');
			$table->string('invoice_type')->default('CustomerInvoice');
			$table->date('week_start_date');	
			$table->decimal('percentage',5,2)->default(100);
			$table->decimal('amount',14,5)->default(0);
			$table->integer('company_id');
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
        Schema::dropIfExists('weekly_cashflow_custom_due_invoices');
    }
}
