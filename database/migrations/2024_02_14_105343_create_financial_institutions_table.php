<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_institutions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type')->nullable();
            $table->string('branch_name')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('name')->nullable();
            $table->string('company_account_number')->nullable();
            $table->string('iban_code')->nullable();
            $table->string('current_account_number')->nullable();
            $table->string('main_currency')->nullable();
            $table->string('balance_amount')->nullable();
            $table->date('balance_date')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_institutions');
    }
}
