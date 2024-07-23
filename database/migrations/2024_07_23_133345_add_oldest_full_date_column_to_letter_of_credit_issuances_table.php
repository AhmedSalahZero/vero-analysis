<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldestFullDateColumnToLetterOfCreditIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_credit_issuances', function (Blueprint $table) {
            $table->date('oldest_full_date')->nullable()->after('cash_cover_account_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_credit_issuances', function (Blueprint $table) {
            //
        });
    }
}
