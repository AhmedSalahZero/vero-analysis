<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLetterOfCreditIssuanceIdToSettlementAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlement_allocations', function (Blueprint $table) {
            $table->unsignedBigInteger('letter_of_credit_issuance_id')->after('money_payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlement_allocations', function (Blueprint $table) {
            //
        });
    }
}
