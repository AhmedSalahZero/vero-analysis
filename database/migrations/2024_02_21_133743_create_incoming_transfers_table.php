<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// Schema::create('financial_institution_accounts', function (Blueprint $table) {
        //     $table->integer('account_number')->unique()->index()->change();
        // });
		
        Schema::create('incoming_transfers', function (Blueprint $table) {
            $table->id();
			$table->integer('money_received_id');
			$table->foreign('money_received_id')->references('id')->on('money_received')->cascadeOnDelete();
			$table->integer('receiving_bank_id')->nullable();
			$table->foreign('receiving_bank_id')->references('id')->on('financial_institutions')->nullOnDelete();
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
        Schema::dropIfExists('incoming_transfers');
    }
}
