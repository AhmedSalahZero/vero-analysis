<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLgIssuanceAdvancedPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_issuance_advanced_payment_histories', function (Blueprint $table) {
            $table->id();
			$table->date('date')->nullable();
			$table->decimal('amount',14,2);
			$table->unsignedBigInteger('letter_of_guarantee_issuance_id');
			$table->foreign('letter_of_guarantee_issuance_id','lg_issuance_advanced_foreign')->references('id')->on('letter_of_guarantee_issuances')->cascadeOnDelete();
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
        Schema::dropIfExists('lg_advanced_payment_histories');
    }
}
