<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMinCommissionFeesToLetterOfGuaranteeFacilityTermAndConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_facility_term_and_conditions', function (Blueprint $table) {
			$table->decimal('min_commission_fees',20,2)->after('commission_interval')->default(0);
			$table->decimal('issuance_fees',20,2)->after('min_commission_fees')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_guarantee_facility_term_and_conditions', function (Blueprint $table) {
            //
        });
    }
}
