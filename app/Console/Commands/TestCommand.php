<?php

namespace App\Console\Commands;

use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\LetterOfCreditIssuance;
use App\Models\PurchaseOrder;
use App\Services\Api\OddoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
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
	// dd(number_unformat('salah'),is_numeric('15,000'));
		// $lcAmount = 4100.0; 
		$currency = 'USD';
		$letterOfCreditIssuance = LetterOfCreditIssuance::find(23);
		$lcAmount = $letterOfCreditIssuance->getLcAmount();
		$invoices = \App\Models\SupplierInvoice::onlyCompany(92)->onlyForPartner(262)
										->where('net_balance','>=',$lcAmount)
										->onlyCurrency($currency)
										->get();
										dd($invoices);
		// dd('5000.0' < 10000000);
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
