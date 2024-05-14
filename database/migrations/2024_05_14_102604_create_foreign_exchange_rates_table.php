<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_exchange_rates', function (Blueprint $table) {
            $table->id();
			$table->string('from_currency');
			$table->string('to_currency');
			$table->date('date');
			$table->decimal('exchange_rate',10,4)->default(1);
			$table->unsignedBigInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('foreign_exchange_rates');
    }
}
