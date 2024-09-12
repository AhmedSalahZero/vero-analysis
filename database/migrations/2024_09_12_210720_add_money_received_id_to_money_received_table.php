<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoneyReceivedIdToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received', function (Blueprint $table) {
            $table->unsignedBigInteger('money_received_id')->after('id')->nullable()->comment('دا خاص بالدفعه المقدمه لو تم انشائها عن طريق 
			unapplied_amount
			علشان تعرف ال 
			down payment 
			دي تبع انهي 
			money received
			');
        });
		
		
		Schema::table('money_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('money_payment_id')->after('id')->nullable()->comment('دا خاص بالدفعه المقدمه لو تم انشائها عن طريق 
			unapplied_amount
			علشان تعرف ال 
			down payment 
			دي تبع انهي 
			money payment
			');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('money_received', function (Blueprint $table) {
            //
        });
    }
}
