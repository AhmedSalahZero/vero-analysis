<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdColumnToLgIssuanceAdvancedPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lg_issuance_advanced_payment_histories', function (Blueprint $table) {
			$table->unsignedBigInteger('company_id')->after('letter_of_guarantee_issuance_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lg_issuance_advanced_payment_histories', function (Blueprint $table) {
            //
        });
    }
}
