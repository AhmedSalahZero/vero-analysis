<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnPayloadToHiringCountsToPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(FINANCIAL_PLANNING_CONNECTION_NAME)->table('positions', function (Blueprint $table) {
            $table->renameColumn('payload','hiring_counts');
			$table->json('manpower_salaries')->nullable();
            $table->json('accumulated_manpower_counts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
    }
}
