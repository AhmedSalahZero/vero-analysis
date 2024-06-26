<?php

namespace App\Jobs\Caches;

use App\Models\CachingCompany;
use App\Models\Company;
use App\Services\Caching\CashingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class HandleBreakdownDashboardCashingJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $timeout = 500000 * 60;
	public $failOnTimeout = true;

	private Company $company;

	public function __construct(Company $company)
	{
		$this->company = $company;
	}

	public function handle()
	{
		$cachingService = new CashingService($this->company);
		$cachingService->refreshBreakdownDashboardCashing();
		// for the last one 
		$this->company->update([
			'is_caching_now'=>false 
		]);
	}
}
