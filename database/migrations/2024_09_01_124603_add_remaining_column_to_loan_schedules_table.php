<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingColumnToLoanSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_schedules', function (Blueprint $table) {
			$table->decimal('remaining',14,2)->after('end_balance')->default(0);
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_schedules', function (Blueprint $table) {
            $table->decimal('remaining',14,2)->after('end_balance')->default(0);
        });
    }
}
