<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFinancingDurationColumnToLetterOfCreditFacilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_credit_facilities', function (Blueprint $table) {
            $table->removeColumn('financing_duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_credit_facilites', function (Blueprint $table) {
            //
        });
    }
}
