<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Services\Api\OddoService;

use Illuminate\Console\Command;

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
		$companies = Company::all();
		foreach($companies as $company){
			if($company->hasOddoIntegrationCredentials()){
				$oddo = new OddoService($company->getOddoDBUrl(),$company->getOddoDBName(),$company->getOddoDBUserName(),$company->getOddoDBPassword(),$company->getId());
				$importDate = now()->subDay()->format('Y-m-d') ; ;
				$oddo->startImport($importDate);
			}
		}
		

	}
	public function refreshStatement($statementModelName,$dateColumnName = 'full_date'){
		$fullModelName ='App\Models\\'.$statementModelName;
		$fullModelName::orderBy($dateColumnName)->get()->each(function($statementRaw){
			$statementRaw->update([
				'updated_at'=>now()
			]);
		});
	}
}
