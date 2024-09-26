<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSectorsFromExistingOnes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['cash_vero_business_units','cash_vero_sales_persons','cash_vero_business_sectors','cash_vero_sales_channels','cash_vero_branches'] as $mainTableName){
			Schema::create($mainTableName,function(Blueprint $table){
				$table->id();
				$table->string('name');
				$table->unsignedBigInteger('company_id');
				$table->timestamps();
			});
		}
		$CompanyIds = DB::table('customer_invoices')->pluck('company_id')->unique()->values()->toArray();
		foreach($CompanyIds as $companyId){
			foreach(['business_unit'=>'cash_vero_business_units','sales_person'=>'cash_vero_sales_persons','business_sector'=>'cash_vero_business_sectors','sales_channel'=>'cash_vero_sales_channels'] as $columnName => $tableName){
				if($columnName == 'sales_channel'){
					continue;
				}
				 $items= DB::table('customer_invoices')->where('company_id',$companyId)->where($columnName,'!=','')->pluck($columnName)->unique()->values()->toArray();
				 $items = array_map(function($name) use ($companyId){
					return ['name'=>$name , 'company_id'=>$companyId,'created_at'=>now()];
				 },$items);
				 foreach($items as $itemArr){
					 DB::table($tableName)->insert($itemArr);
				 }
			}
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
       
    }
}
