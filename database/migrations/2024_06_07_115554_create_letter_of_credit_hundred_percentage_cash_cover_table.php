<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfCreditHundredPercentageCashCoverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		SChema::dropIfExists('lc_hundred_percentage_cash_cover_opening_balances');
        Schema::create('lc_hundred_percentage_cash_cover_opening_balances', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->string('lc_type');
            $table->integer('financial_institution_id');
            $table->foreign('financial_institution_id','lc__fname')->references('id')->on('financial_institutions')->cascadeOnDelete();
            $table->unsignedBigInteger('lc_opening_balance_id');
            $table->date('lc_expiry_date');
            $table->foreign('lc_opening_balance_id','lc__opname')->references('id')->on('letter_of_credit_opening_balances')->cascadeOnDelete();
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
        Schema::dropIfExists('lc_hundred_percentage_cash_cover_opening_balances');
    }
}
