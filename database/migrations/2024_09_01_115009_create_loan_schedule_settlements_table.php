<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanScheduleSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_schedule_settlements', function (Blueprint $table) {
            $table->id();
			$table->string('current_account_number');
			$table->unsignedBigInteger('loan_schedule_id');
			$table->date('date');
			$table->decimal('amount',14,2);
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
        Schema::dropIfExists('loan_schedule_settlments');
    }
}
