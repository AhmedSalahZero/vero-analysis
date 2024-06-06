<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdColumnToLendingInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lending_information', function (Blueprint $table) {
            $table->dropColumn('customer_name');
			$table->unsignedBigInteger('customer_id')->after('max_lending_limit_per_customer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lending_information', function (Blueprint $table) {
            //
        });
    }
}
