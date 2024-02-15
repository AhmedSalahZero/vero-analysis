<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverdraftAgainstCommercialPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdraft_against_commercial_papers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('financial_institution_id')->nullable();
            $table->integer('company_id');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('account_number')->nullable();
            $table->string('currency')->nullable();
            $table->string('limit')->nullable();
            $table->string('outstanding_balance')->nullable();
            $table->date('balance_date')->nullable();
            $table->string('borrowing_rate')->nullable();
            $table->float('bank_margin_rate', 10, 0)->nullable()->default(0);
            $table->float('interest_rate', 10, 0)->nullable()->default(0);
            $table->float('min_interest_rate', 10, 0)->nullable()->default(0);
            $table->float('highest_debt_balance_rate', 10, 0)->nullable()->default(0);
            $table->float('admin_fees_rate', 10, 0)->nullable()->default(0);
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
        Schema::dropIfExists('overdraft_against_commercial_papers');
    }
}
