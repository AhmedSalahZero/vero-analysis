<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['clean_overdraft_rates','fully_secured_overdraft_rates','overdraft_against_assignment_of_contract_rates','overdraft_against_commercial_paper_rates','loan_schedule_settlements'] as $tableName){
			Schema::table($tableName,function(Blueprint $table){
				$table->unsignedBigInteger('company_id')->after('id')->nullable();
			});
		}
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
