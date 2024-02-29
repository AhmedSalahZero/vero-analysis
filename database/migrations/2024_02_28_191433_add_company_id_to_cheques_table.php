<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheques', function (Blueprint $table) {
           $table->integer('company_id')->nullable();
        });
		Schema::table('cash_in_banks', function (Blueprint $table) {
			$table->integer('company_id')->nullable();
		 });
		 
		 Schema::table('cash_in_safes', function (Blueprint $table) {
			$table->integer('company_id')->nullable();
		 });
		 
		 Schema::table('incoming_transfers', function (Blueprint $table) {
			$table->integer('company_id')->nullable();
		 });
		 
		 
		 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cheques', function (Blueprint $table) {
            //
        });
    }
}
