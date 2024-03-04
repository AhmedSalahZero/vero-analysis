<?php

namespace App\Jobs;

use App\Models\CachingCompany;
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

    public function __construct($company_id,$modelName)
    {
        $this->company_id = $company_id;
        $this->modelName = $modelName;
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
				
				$chunk = $this->ReplaceAllSpecialCharactersInArrayValuesAndAddExtraFieldsToBeStored($chunk,$this->modelName);
				
                DB::table($modelTableName)->insert($chunk);
                $key = getTotalUploadCacheKey($this->company_id , $cachingCompany->job_id,$modelTableName) ;
                $oldTotalUploaded = cache::get($key) ?:0 ;
                cache::forever( $key , $oldTotalUploaded + count($chunk) );
            }
        });
    }
	public function ReplaceAllSpecialCharactersInArrayValuesAndAddExtraFieldsToBeStored(array $items,$modelName )
	{
		$newItems = [];
		foreach($items as $key => $value) {
			$newItems[$key]=$value ? str_replace(array('"', "'","\\"), ' ', $value) : $value;
			if($modelName == 'CustomerInvoice' && is_array($value)){
				$customerId = null ;
				if($this->modelName == 'CustomerInvoice'){
					$customerId = 0 ;
					$customerName = $value['customer_name'] ;
					$customerFound = $customerId ? true : DB::table('partners')->where('name',$customerName)->exists();
					if($customerFound){
						$customerId = DB::table('partners')->where('name',$customerName)->first()->id;
					}else{
						$customer = Partner::create([
							'name'=>$customerName,
							'company_id'=>$this->company_id,
							'is_customer'=>1 ,
							'is_supplier'=>0 
						]);
						$customerId = $customer->id ;
					}
					;
				}
			$newItems[$key] = array_merge($value , [
				'customer_id'=>$customerId
			]);
			}
			
		}
		/**
		 * * add additional fields to be stored
		 */
		// logger($key . );
		

		return $newItems ;
	}
}
