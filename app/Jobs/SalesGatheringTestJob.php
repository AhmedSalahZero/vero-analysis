<?php

namespace App\Jobs;

use App\Models\CachingCompany;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SalesGatheringTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels ;
	
    public $timeout = 500000*60;
    public $failOnTimeout = true;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $company_id;
    public $modelName;
	public $loanId ; 
    public function __construct($company_id,$modelName,$loanId = null)
    {
        $this->company_id = $company_id;
        $this->modelName = $modelName;
		$this->loanId = $loanId ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */


    public function handle()
    {
		$uploadParamsForType = getUploadParamsFromType($this->modelName);
		$modelTableName = $uploadParamsForType['dbName'];
		
        CachingCompany::where('company_id' , $this->company_id )->get()->each(function($cachingCompany) use($modelTableName){
            $cacheGroup = Cache::get($cachingCompany->key_name) ?: [];
            $chunks = \array_chunk($cacheGroup ,1000);
            foreach($chunks as $chunk)
            {
				
				$chunk = $this->ReplaceAllSpecialCharactersInArrayValuesAndAddExtraFieldsToBeStored($chunk,$this->modelName,$this->loanId);
				
                DB::table($modelTableName)->insert($chunk);
                $key = getTotalUploadCacheKey($this->company_id , $cachingCompany->job_id,$modelTableName) ;
                $oldTotalUploaded = cache::get($key) ?:0 ;
                cache::forever( $key , $oldTotalUploaded + count($chunk) );
            }
        });
    }
	public function ReplaceAllSpecialCharactersInArrayValuesAndAddExtraFieldsToBeStored(array $items,$modelName ,$loanId )
	{
		$newItems = [];
		foreach($items as $key => $value) {
			$newItems[$key]=$value ? str_replace(array('"', "'","\\"), ' ', $value) : $value;
			
			if($modelName == 'CustomerInvoice' && is_array($value)){
				$customerId = null ;
				if($this->modelName == 'CustomerInvoice'){
					/**
					 * * insert customer invoices
					 */
					$customerId = 0 ;
					$customerName = $value['customer_name'] ;
					$value['currency'] = isset($value['currency']) ? strtoupper($value['currency']) : null;
					$customerFound = $customerId ? true : DB::table('partners')->where('company_id',$this->company_id)->where('is_customer',1)->where('name',$customerName)->exists();
					if($customerFound){
						$customerId = DB::table('partners')->where('company_id',$this->company_id)->where('is_customer',1)->where('name',$customerName)->first()->id;
					}else{
						$customer = Partner::create([
							'name'=>$customerName,
							'company_id'=>$this->company_id,
							'is_customer'=>1 ,
							'is_supplier'=>0 
						]);
						$customerId = $customer->id ;
					}
					/**
					 * * insert sales person , business unit , business sector
					 */
					
					foreach(['sales_person'=>'cash_vero_sales_persons','business_unit'=>'cash_vero_business_units','business_sector'=>'cash_vero_business_sectors'] as $columnName=>$tableName){
						$currentIds[$columnName] = 0 ;
						$currentColValue = $value[$columnName] ;
					$isFound[$columnName] = $currentIds[$columnName] ? true : DB::table($tableName)->where('company_id',$this->company_id)->where('name',$currentColValue)->exists();
					if($isFound[$columnName]){
						$currentIds[$columnName] = DB::table($tableName)->where('company_id',$this->company_id)->where('name',$currentColValue)->first()->id;
					}else{
						$currentRowInserted = DB::table($tableName)->insert([
							'name'=>$currentColValue,
							'created_at'=>now(),
							'company_id'=>$this->company_id
						]);
						$currentIds[$columnName] = $currentRowInserted ;
					}
					}
					
				
					
					
					/**
					 * * insert customer contracts
					 */
					
					 
					$contractName = $value['contract_name']??null ;
					$contractCode = $value['contract_code']??null ;
					$contractAmount = $value['contract_amount']??null ;
					$contractDate = $value['contract_date'] ?? null ;
					$contractFound =  DB::table('contracts')->where('company_id',$this->company_id)->where('code',$contractCode)->exists();
					if($contractName && $contractCode && $contractAmount && $contractDate && !$contractFound){
						$customer = Contract::create([
							'status'=>Contract::RUNNING,
							'model_type'=>'Customer',
							'partner_id'=>$customerId,
							'name'=>$contractName,
							'code'=>$contractCode,
							'company_id'=>$this->company_id ,
							'start_date'=>$contractDate,
							'duration'=>0,
							'end_date'=>null,
							'amount'=>$contractAmount ,
							'currency'=>isset($value['currency']) ? strtoupper($value['currency']) : null,
							'exchange_rate'=>isset($value['exchange_rate']) ? strtoupper($value['exchange_rate']) : 1
						]);	
					}
					
					
					
				}
			$newItems[$key] = array_merge($value , [
				'customer_id'=>$customerId
			]);
			}
			
			
			
			
			if($modelName == 'SupplierInvoice' && is_array($value)){
				$supplierId = null ;
				if($this->modelName == 'SupplierInvoice'){
					$supplierId = 0 ;
					$supplierName = $value['supplier_name'] ;
					$value['currency'] = isset($value['currency']) ? strtoupper($value['currency']) : null;
					$supplierFound = $supplierId ? true : DB::table('partners')->where('company_id',$this->company_id)->where('is_supplier',1)->where('name',$supplierName)->exists();
					if($supplierFound){
						$supplierId = DB::table('partners')->where('company_id',$this->company_id)->where('is_supplier',1)->where('name',$supplierName)->first()->id;
					}else{
						$supplier = Partner::create([
							'name'=>$supplierName,
							'company_id'=>$this->company_id,
							'is_customer'=>0 ,
							'is_supplier'=>1 
						]);
						$supplierId = $supplier->id ;
					}
					;
				}
			$newItems[$key] = array_merge($value , [
				'supplier_id'=>$supplierId
			]);
			}
			if($modelName == 'LoanSchedule'){
				$newItems[$key] = array_merge($value , [
					'medium_term_loan_id'=>$loanId,
					'remaining'=>$value['schedule_payment'] ?? 0
				]);
			}
			
		}
		
		return $newItems ;
	}
}
