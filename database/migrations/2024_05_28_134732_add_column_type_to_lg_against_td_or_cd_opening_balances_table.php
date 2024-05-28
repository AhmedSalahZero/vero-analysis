<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeToLgAgainstTdOrCdOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lg_against_td_or_cd_opening_balances', function (Blueprint $table) {
            $table->string('type')->comment('CertificateOfDeposit , TimeOfDeposit')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lg_against_td_or_cd_opening_balances', function (Blueprint $table) {
            //
        });
    }
}
