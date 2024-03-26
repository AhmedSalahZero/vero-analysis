<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractIdToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_id')->after('id')->nullable()->comment('في حاله لو كان downpayment اي دفعه مقدمة');
			$table->foreign('contract_id')->references('id')->on('contracts');
			$table->enum('money_type',['money-received','down-payment'])->default('money-received')->after('id');
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
