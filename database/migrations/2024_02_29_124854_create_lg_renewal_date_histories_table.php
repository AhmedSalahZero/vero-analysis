<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLgRenewalDateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_renewal_date_histories', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('letter_of_guarantee_issuance_id');
			$table->foreign('letter_of_guarantee_issuance_id','lg_renewal_foreign')->references('id')->on('letter_of_guarantee_issuances')->cascadeOnDelete();
            $table->string('renewal_date')->comment('تاريخ التجديد');
            $table->decimal('fees_amount',14,2)->comment('هي عبارة عن المبلغ اللي هيدفعه للبنك علشان يجدد');
			$table->integer('company_id');
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
        Schema::dropIfExists('lg_renewal_date_histories');
    }
}
