<?php

namespace App\Console\Commands;


use App\Models\Branch;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class TestCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'run:test';

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
		foreach(Company::all() as $company){
			$companyId = $company->id ;
			$bank = DB::table('branch')->where('company_id',$companyId)->orderByRaw('created_at asc')->first();
			if(!$bank){
				Branch::storeHeadOffice($companyId);
			}
		}
	}
}
