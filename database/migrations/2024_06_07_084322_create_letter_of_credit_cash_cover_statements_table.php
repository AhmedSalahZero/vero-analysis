<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterOfCreditCashCoverStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		SChema::dropIfExists('letter_of_credit_cash_cover_statements');
        Schema::create('letter_of_credit_cash_cover_statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
			$table->string('source')->comment('هو المكان او الطريقه يعني اللي انت انشاتة بيها وانت عندك ثلاث او اربع زراير دول عباره عن المصدر اللي هو قيمة الكولوم دا');
			$table->unsignedBigInteger('financial_institution_id');
			$table->unsignedBigInteger('letter_of_credit_issuance_id');
            $table->unsignedBigInteger('lc_facility_id')->nullable();
            $table->string('lc_type');
            $table->string('currency')->nullable();
            $table->boolean('is_debit')->default(false);
            $table->boolean('is_credit')->default(true);
            $table->unsignedBigInteger('company_id');
            $table->date('date')->nullable();
            $table->dateTime('full_date')->nullable();
            $table->decimal('beginning_balance', 14)->default(0);
            $table->decimal('debit', 14,2)->default(0);
            $table->decimal('credit', 14,2)->default(0);
            $table->decimal('end_balance', 14)->default(0);
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
        Schema::dropIfExists('letter_of_credit_cash_cover_statements');
    }
}
