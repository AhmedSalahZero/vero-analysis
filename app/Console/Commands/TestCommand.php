<?php

namespace App\Console\Commands;

use App\Http\Controllers\Analysis\SalesGathering\salesReport;
use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\LetterOfCreditIssuance;
use App\Models\PurchaseOrder;
use App\Services\Api\OddoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Schema;

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
		$request = new Request();
		$request->merge([
			'name'=>'ahmed'
		]);
		Request()->merge(['name'=>'ali']);
		dd($request->name,Request('name'));
		// $request = new Request;
		// $company = Company::find(105);
		// $request->merge([
		// 	'start_date'=>'2022-11-01',
		// 	'end_date'=>'2024-11-30',
		// 	'report_type'=>'comparing',
		// 	'company_id'=>$company->id
		// ]); 
		// $salesReport = new salesReport;
	
		// $predict = $salesReport->predictSales($request,$company,'branch','array');
	}
	public function refreshStatement($statementModelName,$dateColumnName = 'full_date'){
		$fullModelName ='App\Models\\'.$statementModelName;
		$fullModelName::orderBy($dateColumnName)->get()->each(function($statementRaw){
			$statementRaw->update([
				'updated_at'=>now()
			]);
		});
	}
	public function getTableNamesThatHasColumn(string $columnName)
	{
		$result = [];
		$tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
		foreach($tables as $tableName){
			if(Schema::hasColumn($tableName,$columnName)){
				$result[] = $tableName;
			}
		}
		return $result; 
	}
}
