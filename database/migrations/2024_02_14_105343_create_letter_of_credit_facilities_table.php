<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfCreditFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_of_credit_facilities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('financial_institution_id')->nullable();
            $table->integer('company_id');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('limit')->nullable();
            $table->string('financial_duration')->nullable();
            $table->string('borrowing_rate')->nullable();
            $table->string('bank_margin_rate')->nullable();
            $table->string('interest_rate')->nullable();
            $table->string('min_interest_rate')->nullable();
            $table->string('highest_debt_balance_rate')->nullable();
            $table->string('admin_fees_rate')->nullable();
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
        Schema::dropIfExists('letter_of_credit_facilities');
    }
}
