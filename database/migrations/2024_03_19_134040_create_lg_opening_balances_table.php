<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLgOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_opening_balances', function (Blueprint $table) {
            $table->id();
			$table->date('date')->nullable();
			$table->unsignedBigInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
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
        Schema::dropIfExists('lg_opening_balances');
    }
}
