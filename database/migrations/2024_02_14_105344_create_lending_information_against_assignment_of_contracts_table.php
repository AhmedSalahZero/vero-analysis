<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLendingInformationAgainstAssignmentOfContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lending_information_against_assignment_of_contracts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('overdraft_against_assignment_of_contracts_id')->nullable();
            // $table->string('max_lending_limit_per_contract')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            // $table->integer('to_be_setteled_max_within_days')->nullable()->default(0);
            $table->float('lending_rate', 10, 0)->nullable()->default(0);
            // $table->integer('for_commercial_papers_due_within_days')->nullable()->default(0);
            $table->integer('company_id')->nullable();
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
        Schema::dropIfExists('lending_information_against_assignment_of_contracts');
    }
}
