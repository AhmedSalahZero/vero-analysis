<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialInstitutionAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_institution_accounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('financial_institution_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('currency')->nullable();
            $table->double('balance_amount')->nullable()->default(0);
            $table->date('balance_date')->nullable();
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
        Schema::dropIfExists('financial_institution_accounts');
    }
}
