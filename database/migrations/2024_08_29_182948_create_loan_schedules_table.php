<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('medium_term_loan_id');
			$table->foreign('medium_term_loan_id')->references('id')->on('medium_term_loans');
			$table->date('date')->nullable();
			$table->decimal('beginning_balance',14,2)->nullable()->default(0);
			$table->decimal('schedule_payment',14,2)->nullable()->default(0);
			$table->decimal('interest_amount',14,2)->nullable()->default(0);
			$table->decimal('principle_amount',14,2)->nullable()->default(0);
			$table->decimal('end_balance',14,2)->nullable()->default(0);
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('company_id');
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
        Schema::dropIfExists('loan_schedules');
    }
}
