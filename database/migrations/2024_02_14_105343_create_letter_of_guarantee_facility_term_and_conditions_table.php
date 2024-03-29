<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfGuaranteeFacilityTermAndConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_of_guarantee_facility_term_and_conditions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('letter_of_guarantee_facility_id')->nullable();
            $table->integer('company_id');
            $table->date('outstanding_date')->nullable();
            $table->string('lg_type')->nullable();
            $table->string('outstanding_balance')->nullable();
            $table->string('cash_cover_rate')->nullable();
            $table->string('commission_rate')->nullable();
            $table->string('commission_interval')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('letter_of_guarantee_facility_term_and_conditions');
    }
}
