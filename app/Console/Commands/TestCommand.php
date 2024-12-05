<?php

namespace App\Console\Commands;

use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;

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
