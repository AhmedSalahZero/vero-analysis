<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInSafesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_in_safes', function (Blueprint $table) {
            $table->id();
			$table->integer('money_received_id');
			$table->foreign('money_received_id')->references('id')->on('money_received')->cascadeOnDelete();
			$table->integer('receiving_branch_id')->nullable();
			$table->foreign('receiving_branch_id')->references('id')->on('branch')->nullOnDelete();
			$table->string('receipt_number')->nullable();
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
        Schema::dropIfExists('cash_in_safes');
    }
}
