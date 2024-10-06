<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;

class RefreshPer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('partners',function(Blueprint $table){
			$table->unsignedBigInteger('is_employee')->after('is_supplier')->default(0);
			$table->unsignedBigInteger('is_shareholder')->after('is_employee')->default(0);
			$table->unsignedBigInteger('is_subsidiary_company')->after('is_shareholder')->default(0);
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
        //
    }
}
