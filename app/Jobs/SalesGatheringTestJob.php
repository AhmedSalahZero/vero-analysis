<?php

namespace App\Jobs;

use App\Imports\CustomerInvoiceTestImport;
use App\Models\CachingCompany;
use App\Models\CustomersInvoice;
use App\Models\Deduction;
use App\Models\SalesGathering;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
				$chunk = \replace_all_spacial_character_in_array_values($chunk);
                DB::table($modelTableName)->insert($chunk);
                $key = getTotalUploadCacheKey($this->company_id , $cachingCompany->job_id,$modelTableName) ;
                $oldTotalUploaded = cache::get($key) ?:0 ;
                cache::forever( $key , $oldTotalUploaded + count($chunk) );
            }
                
            
          
        });
        
    }
}
