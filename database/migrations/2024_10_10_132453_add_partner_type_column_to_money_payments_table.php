<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddPartnerTypeColumnToMoneyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_payments', function (Blueprint $table) {
            $table->string('partner_type')->after('id')->default('is_supplier');
        });
		Artisan::call('refresh:permissions');
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('money_payments', function (Blueprint $table) {
            //
        });
    }
}
