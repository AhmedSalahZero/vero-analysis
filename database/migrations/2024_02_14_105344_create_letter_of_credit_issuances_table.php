<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfCreditIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_of_credit_issuances', function (Blueprint $table) {
            $table->id();
			$table->string('transaction_name')->nullable();
            $table->integer('financial_institution_id')->nullable();
			$table->foreign('financial_institution_id')->references('id')->on('financial_institutions')->cascadeOnDelete();
			$table->decimal('total_lc_outstanding_balance',14,2)->default(0);
			$table->string('lc_type')->nullable();
			$table->decimal('lc_type_outstanding_balance',14,2)->default(0);
			$table->string('lc_code')->nullable();
			$table->unsignedBigInteger('partner_id')->nullable();
			$table->foreign('partner_id')->references('id')->on('partners')->cascadeOnDelete();
			
			$table->unsignedBigInteger('contract_id')->nullable();
			$table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
			
			
			$table->unsignedBigInteger('purchase_order_id')->nullable();
			$table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->cascadeOnDelete();
			
			$table->date('purchase_order_date')->nullable();
			
			
			$table->date('issuance_date')->nullable();
			$table->integer('lc_duration_months')->nullable();
			$table->date('lc_due_date')->nullable();
			
			$table->decimal('lc_amount',14,2)->default(0);
            $table->string('lc_currency')->nullable();
            $table->decimal('cash_cover_rate',5,2)->default(0);
			$table->decimal('cash_cover_amount',14,2)->default(0);
            $table->string('cash_cover_deducted_from_account_type')->nullable();
            $table->string('cash_cover_deducted_from_account_number')->nullable();
            $table->decimal('lc_commission_rate',5,2)->default(0);
			$table->decimal('lc_commission_amount',14,2)->default(0);
            $table->string('lc_commission_interval')->nullable();
            

			
            $table->integer('company_id');
			
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_of_credit_issuances');
    }
}
