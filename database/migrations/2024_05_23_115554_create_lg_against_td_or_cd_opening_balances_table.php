<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLgAgainstTdOrCdOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_against_td_or_cd_opening_balances', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->string('lg_type');
            $table->integer('financial_institution_id');
            $table->foreign('financial_institution_id','td_f_fname')->references('id')->on('financial_institutions')->cascadeOnDelete();
            $table->unsignedBigInteger('lg_opening_balance_id');
            $table->date('lg_end_date');
            $table->foreign('lg_opening_balance_id','td_opname')->references('id')->on('letter_of_guarantee_opening_balances')->cascadeOnDelete();
            $table->string('account_type')->comment('td or cd only');
            $table->string('account_number')->comment('td or cd account number');
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
        Schema::dropIfExists('lg_against_td_or_cd_opening_balances');
    }
}
