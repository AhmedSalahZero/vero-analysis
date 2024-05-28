<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLetterOfGuaranteeIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
            $table->decimal('min_lg_commission_fees',14,2)->after('lg_currency')->default(0);
            $table->decimal('issuance_fees',14,2)->after('lg_currency')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
            //
        });
    }
}
