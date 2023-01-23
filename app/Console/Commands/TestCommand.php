<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\SalesForecast;
use App\Models\SalesGathering;
use App\Services\Caching\CashingService;
use App\Services\Caching\CustomerDashboardCashing;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Code Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // getNewCustomersCacheNameForCompanyInYearForType($this->company , $this->year , $typeToCache) ;
        $company=  Company::find(25);
        $newCustomer = (new CustomerDashboardCashing($company,2020))->cacheNewCustomersForTypes();
        dd($newCustomer);
        $year = 2020 ; 
        $companyId = 25 ; 
        $data = Cache::get('new_customers_for_company_'.$companyId .'_for_year_'.$year.'for_type_' . 'zone');
        // return  ;
        // dd(indexIsExistIn('min__index','sales_gathering'));
    
        // dispatch(function(){
        //     SalesGathering::where('company_id' , 41)->chunk(1000 , function($items){
        //         foreach($items as $item)
        //         {
        //             logger('deleted Item  ' . $item->id);
        //             $item->delete();
        //         }
        //     });    
        // });       
    }

}