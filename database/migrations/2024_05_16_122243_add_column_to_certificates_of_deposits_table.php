<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCertificatesOfDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates_of_deposits', function (Blueprint $table) {
			$table->date('break_date')->comment('هو عباره عن التاريخ اللي قررت فية تكسر شهادة الايداع')->nullable();
			$table->decimal('break_interest_amount',14,2)->nullable()->comment('عباره عن الفايدة اللي نزلت علي الحساب بسبب كسرك الشهادة');
			$table->decimal('break_charge_amount',14,2)->nullable()->comment('عبارة عن رسوم ادارية بسبب كسر الشهادة');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates_of_deposits', function (Blueprint $table) {
			
        });
    }
}
