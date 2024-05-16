<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeOfDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_of_deposits', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('status')->default('running');
            $table->integer('financial_institution_id');
            $table->string('account_number')->nullable();
            $table->decimal('amount', 12)->nullable();
            $table->string('currency')->nullable();
            $table->decimal('interest_rate', 5)->default(0);
            $table->decimal('interest_amount', 14)->default(0);
            $table->decimal('actual_interest_amount', 14)->nullable();
            $table->date('deposit_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('maturity_amount_added_to_account_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->decimal('updated_at', 10, 0)->nullable();
            $table->date('break_date')->nullable()->comment('هو عباره عن التاريخ اللي قررت فية تكسر شهادة الايداع');
            $table->decimal('break_interest_amount', 14)->nullable()->comment('عباره عن الفايدة اللي نزلت علي الحساب بسبب كسرك الشهادة');
            $table->decimal('break_charge_amount', 14)->nullable()->comment('عبارة عن رسوم ادارية بسبب كسر الشهادة');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_of_deposits');
    }
}
