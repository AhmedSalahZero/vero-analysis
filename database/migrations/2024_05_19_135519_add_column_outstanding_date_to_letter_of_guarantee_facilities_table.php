<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOutstandingDateToLetterOfGuaranteeFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_facilities', function (Blueprint $table) {
			$table->date('outstanding_date')->after('limit')->nullable();
			$table->decimal('outstanding_amount',20,2)->after('outstanding_date')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_guarantee_facilities', function (Blueprint $table) {
            //
        });
    }
}
