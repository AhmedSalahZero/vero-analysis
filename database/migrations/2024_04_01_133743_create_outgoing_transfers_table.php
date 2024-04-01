<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_transfers', function (Blueprint $table) {
            $table->id();
			$table->integer('money_payment_id');
			$table->foreign('money_payment_id')->references('id')->on('money_payments')->cascadeOnDelete();
			$table->integer('delivery_bank_id')->nullable();
			$table->foreign('delivery_bank_id')->references('id')->on('financial_institutions')->nullOnDelete();
			$table->string('account_type')->nullable();
			$table->bigInteger('account_number')->unsigned()->nullable();
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
        Schema::dropIfExists('outgoing_transfers');
    }
}
