<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverdraftAgainstAssignmentOfContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdraft_against_assignment_of_contracts', function (Blueprint $table) {
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
            $table->decimal('max_lending_limit_per_contract',14,2)->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->integer('to_be_setteled_max_within_days')->nullable()->default(0);
            $table->dateTime('start_settlement_from_bank_statement_date')->nullable();
            $table->dateTime('oldest_full_date')->nullable();
            // $table->boolean('origin_update_row_is_debit')->nullable()->default(false)->comment('دلوقت احنا لما بنحدث وليكن ماني ريسيفد .. عايز نعرف ان الرو الاصلي اللي عدلناه كان ماني ريسيفد');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overdraft_against_assignment_of_contracts');
    }
}
