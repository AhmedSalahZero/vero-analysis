<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLcFacilityExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_facility_expenses', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('company_id');
			$table->unsignedBigInteger('lc_facility_id');
			$table->date('date');
			$table->decimal('amount',14,2)->default(0);
			$table->string('currency');
			$table->decimal('exchange_rate',6,3)->default(0);
			$table->decimal('amount_in_main_currency')->default(0);
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
        Schema::dropIfExists('lc_facility_expenses');
    }
}
