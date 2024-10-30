<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdRenewalDateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('td_renewal_date_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('time_of_deposit_id')->index('td_renewal_foreign');
			$table->foreign(['time_of_deposit_id'], 'td_renewal_foreign')->references(['id'])->on('time_of_deposits')->onUpdate('NO ACTION')->onDelete('CASCADE');
            // $table->string('expiry/_date')->comment('تاريخ التجديد');
            $table->string('expiry_date')->nullable()->comment('تاريخ الانتهاء هنحتاجه هنا علشان نجيب بيه ال start date القديمه');
            $table->string('renewal_date')->comment('تاريخ التجديد');
			$table->decimal('interest_rate',8,4);
            // $table->decimal('fees_amount', 14)->default(0)->comment('هي عبارة عن المبلغ اللي هيدفعه للبنك علشان يجدد');
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
        Schema::dropIfExists('td_renewal_date_histories');
    }
}
