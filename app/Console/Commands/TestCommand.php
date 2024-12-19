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
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
		dd($this->runPythonScript());
		// $databaseName = 'salah_db';
		
		// DB::statement("CREATE DATABASE IF NOT EXISTS {$databaseName}");
		// DB::build([
		// 	'driver' => 'mysql',
		// 	'database' => 'forge',
		// 	'username' => 'root',
		// 	'password' => 'secret',
		// ]);
		
		// DB::reconnect('mysql');
	

		// $tableName = 'companies';
		// $columns = [
		// 	'name','age'
		// ];
		// Schema::create($tableName, function (Blueprint $table) use ($columns) {
		// 	$table->id();
		// 	foreach ($columns as $column) {
		// 		$table->string($column);
		// 	}
		// 	$table->timestamps();
		// });
		
		
		
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
	public function runPythonScript()
	{
		$pythonFilePath = public_path('python/test.py');
		$name = "khaled";
		$x = shell_exec('python3 '. $pythonFilePath .' '. $name  );
		dd($x);
	}
}
