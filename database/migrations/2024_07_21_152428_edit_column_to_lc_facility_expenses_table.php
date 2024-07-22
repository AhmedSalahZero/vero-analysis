<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnToLcFacilityExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lc_facility_expenses', function (Blueprint $table) {
			$table->string('expense_name')->after('id')->nullable();
			$table->renameColumn('lc_facility_id','lc_issuance_id');
			$table->rename('lc_issuance_expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lc_facility_expenses', function (Blueprint $table) {
            //
        });
    }
}
