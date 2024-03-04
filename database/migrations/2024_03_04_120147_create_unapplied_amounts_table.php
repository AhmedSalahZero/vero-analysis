<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnappliedAmountsTable extends Migration
{
   
    public function up()
    {
        Schema::create('unapplied_amounts', function (Blueprint $table) {
			$table->id();
			$table->integer('company_id');
			$table->unsignedBigInteger('partner_id');
			$table->foreign('partner_id')->references('id')->on('partners')->cascadeOnDelete();
			$table->integer('money_received_id')->nullable();
			$table->foreign('money_received_id')->references('id')->on('money_received')->cascadeOnDelete();
			$table->date('settlement_date');
			$table->decimal('amount',14,2)->default(0)->comment('هي القيمة ال unapplied الحالية');
			$table->decimal('net_balance_until_date',14,2)->default(0)->comment('هي صافي الرصيد لحد التاريخ الحالي');
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
        Schema::dropIfExists('unapplied_amounts');
    }
}
