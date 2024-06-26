<?php

namespace App\Console\Commands;

use App\Jobs\Caches\HandleBreakdownDashboardCashingJob;
use App\Jobs\Caches\HandleCustomerDashboardCashingJob;
use App\Jobs\Caches\HandleCustomerNatureCashingJob;
use App\Jobs\Caches\RemoveIntervalYearCashingJob;
use App\Models\Company;
use Illuminate\Console\Command;

class StartCashingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'caching:run {company_id?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Caching For Testing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
		// php artisan caching:run 5
		$company_id = $this->argument('company_id');
		
		$companies = [];
		if(count($company_id)){
			$companies = Company::whereIn('id',$company_id)->get();
		}else{
			$companies = Company::all();
		}
        
          foreach($companies as $company){
             dispatch((new RemoveIntervalYearCashingJob($company)));
             dispatch((new HandleCustomerDashboardCashingJob($company)));
             dispatch((new HandleCustomerNatureCashingJob($company)));
             dispatch((new HandleBreakdownDashboardCashingJob($company)));
        }
    }
}
