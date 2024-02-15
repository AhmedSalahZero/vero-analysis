<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLendingInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lending_information', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('overdraft_against_commercial_paper_id')->nullable();
            $table->string('max_lending_limit_per_customer')->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('to_be_setteled_max_within_days')->nullable()->default(0);
            $table->float('lending_rate', 10, 0)->nullable()->default(0);
            $table->integer('for_commercial_papers_due_within_days')->nullable()->default(0);
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
        Schema::dropIfExists('lending_information');
    }
}
