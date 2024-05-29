<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountTypeIdToFullySecuredOverdraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('fully_secured_overdrafts', function (Blueprint $table) {
			$table->decimal('cd_or_td_lending_percentage',14,5)->after('financial_institution_id')->nullable()->default(0);
			$table->unsignedBigInteger('cd_or_td_account_id')->comment('الاي دي بتاع الحساب اللي اختارة وليكن 5')->after('financial_institution_id');
			$table->unsignedBigInteger('cd_or_td_account_number')->comment('هو هو حساب سي دي ولا تي دي ')->after('financial_institution_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fully_secured_overdrafts', function (Blueprint $table) {
            //
        });
    }
}
