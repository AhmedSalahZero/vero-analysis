<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->string('supplier_code')->nullable();
            $table->string('sales_person')->nullable();
            // $table->string('business_unit')->nullable();
            $table->integer('supplier_id');
            $table->string('supplier_name')->nullable();
            $table->string('business_sector')->nullable();
            $table->string('project_name')->nullable();
            $table->string('site_name')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('invoice_month', 2)->nullable();
            $table->mediumInteger('invoice_year')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_amount')->nullable()->default('0');
            $table->string('currency', 10);
            $table->decimal('exchange_rate', 10, 5)->default(1);
            $table->double('invoice_amount_in_main_currency')->nullable()->default(0);
            $table->string('vat_amount')->nullable()->default('0');
            $table->double('vat_amount_in_main_currency')->nullable()->default(0);
            $table->string('withhold_amount')->nullable()->default('0');
            $table->double('withhold_amount_in_main_currency')->nullable()->default(0);
            $table->string('net_invoice_amount')->nullable()->default('0');
            $table->double('net_invoice_amount_in_main_currency')->nullable()->default(0);
            $table->string('contracted_payment_days')->nullable();
            // $table->string('expected_collection_days')->nullable();
            $table->date('invoice_due_date')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('paid_amount')->nullable()->default('0');
            $table->double('paid_amount_in_main_currency')->nullable()->default(0);
            $table->string('net_balance')->nullable()->default('0');
            $table->double('net_balance_in_main_currency')->nullable()->default(0);
            $table->boolean('is_period_closed')->nullable()->default(false);
            $table->boolean('is_canceled')->nullable()->default(false);
            $table->dateTime('created_at')->useCurrent();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->decimal('discount_amount', 14)->nullable()->default(0);
            $table->decimal('discount_amount_in_main_currency', 14)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_invoices');
    }
}
