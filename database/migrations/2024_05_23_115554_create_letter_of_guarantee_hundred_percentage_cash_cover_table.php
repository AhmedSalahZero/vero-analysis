<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfGuaranteeHundredPercentageCashCoverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_hundred_percentage_cash_cover_opening_balances', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->string('lg_type');
            $table->integer('financial_institution_id');
            $table->foreign('financial_institution_id','lg__fname')->references('id')->on('financial_institutions')->cascadeOnDelete();
            $table->unsignedBigInteger('lg_opening_balance_id');
            $table->date('lg_expiry_date');
            $table->foreign('lg_opening_balance_id','lg__opname')->references('id')->on('letter_of_guarantee_opening_balances')->cascadeOnDelete();
            $table->string('current_account_number');
            $table->decimal('amount',20,5)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_of_guarantee_hundred_percentage_cash_cover');
    }
}
