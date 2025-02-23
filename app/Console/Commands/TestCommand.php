<?php

namespace App\Console\Commands;

use App\Helpers\HArr;
use App\Helpers\HDate;
use App\Http\Controllers\FinancialStatementController;
use App\Jobs\TestJob1;
use App\Jobs\TestJob2;
use App\Models\FinancialStatement;
use App\Models\IncomeStatement;
use App\Models\NonBankingService\Study;
use App\ReadyFunctions\OldLoan;
use App\ReadyFunctions\VariableLoanCalculation;
use App\Services\AI\PredictionErrorQualityMeasures\MeanAbsoluteError;
use App\Services\AI\PredictionErrorQualityMeasures\MeanAbsolutePercentageError;
use App\Services\AI\PredictionErrorQualityMeasures\RootMeanSquaredPercentageError;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use MathPHP\Statistics\Correlation;
use PHPUnit\Framework\MockObject\Builder\Stub;
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
	public function convertIncomeStatementDatesToIndexes()
	{
		$financialStatements = FinancialStatement::
	
		get();
		/**
		 * @var FinancialStatement $financialStatement
		 */
		foreach($financialStatements as $financialStatement){
			$request = (new Request)->merge([
				'name'=>$financialStatement->getName(),
				'start_from'=>$financialStatement->start_from,
				'duration'=>$financialStatement->duration,
				'duration_type'=>$financialStatement->duration_type,
				'corporate_taxes_rate'=>22.5
			]);

			$financialStatement->storeMainSection($request);
			$financialStatement->updateIndexedDates();
			$incomeStatement = $financialStatement->incomeStatement;
			if(is_null($incomeStatement)){
				continue;
			}
			$datesHelper = $financialStatement->getDatesIndexesHelper();
			$dateWithDateIndex = $datesHelper['dateWithDateIndex'];
			foreach([
				'financial_statement_able_main_item_calculations',
			'financial_statement_able_main_item_sub_items'] as $tableName){
	
			$rows = DB::table($tableName)
			->where('financial_statement_able_id',$incomeStatement->id)
			->get();
			foreach($rows as $row ){
				
				$indexedPayload = [];
				$payload = (array)json_decode($row->payload);
				foreach($payload as $date => $value){
					$dateIndex = $dateWithDateIndex[$date]??null;
					if(is_null($dateIndex)){
						$indexedPayload[$date] = $value;
						
					}else{
						$indexedPayload[$dateIndex] = $value;
					}
				}
				DB::table($tableName)->where('id',$row->id)->update([
					'payload'=>json_encode($indexedPayload)
				]);
				
			}
		}
		
	}
	dd('good');
		
	}
	public function handle()
	{
		$this->convertIncomeStatementDatesToIndexes();
		return 'done';
		$loanData =  [
		"previousResult" => [],
		"indexOfLoop" => 0,
		"loanType" => "grace_period_with_capitalization",
		"startDate" => "15-10-2026",
		// "startDate" => "31-10-2026",
		"loanAmount" => 10000000.0,
		"baseRate" => "20",
		"marginRate" => 5.0,
		"tenor" => 6.0,
		"installmentPaymentIntervalName" => "monthly",
		"stepUpRate" => 0.0,
		"stepUpIntervalName" => null,
		"stepDownRate" => 0.0,
		"stepDownIntervalName" => null,
		"gracePeriod" => 3.0,
		"dateWithDateIndex" => null,
		"loanStartDateDay" => "31",
		"currentPricing" => 0.25,
		"stepRate" => 0.0,
		"secondMonth" => null,
		"appliedStepName" => null,
		"appliedStepValue" => 12,
		"installmentPaymentIntervalValue" => 1,
		"installmentStartDate" => "15-02-2027",
		// "installmentStartDate" => "28-02-2027",
		"endDate" => "15-04-2027",
		// "endDate" => "30-04-2027",
	];
		$oldLoan = New OldLoan();
		$result = $oldLoan->__calculate($loanData['loanType'],$loanData['startDate'],$loanData['loanAmount'],$loanData['baseRate'],$loanData['marginRate'],$loanData['tenor'],$loanData['installmentPaymentIntervalName'],$loanData['stepUpRate'],$loanData['stepUpIntervalName'],$loanData['stepDownRate'],$loanData['stepDownIntervalName'],$loanData['gracePeriod']);
		dd($result);
		dd('doo');
		$currentLoopItems = ["31-01-2024" => 9257.5,
  "29-02-2024" => 9257.5,
  "31-03-2024" => 9257.5,
  "30-04-2024" => 9257.5,
  "31-05-2024" => 9257.5,
  "30-06-2024" => 9257.5,
  "31-07-2024" => 9257.5,
  "31-08-2024" => 9257.5,
  "30-09-2024" => 9257.5,
  "31-10-2024" => 9257.5,
  "30-11-2024" => 9257.5];
  $monthlySalesForSalesGathering = [
	"31-01-2024" => "10716602.4489",
	"29-02-2024" => "9569762.2328",
	"31-03-2024" => "18761321.8763",
	"30-04-2024" => "8494968.0576",
	"31-05-2024" => "8484082.0538",
	"30-06-2024" => "7786858.6892",
	"31-07-2024" => "19456719.7527",
	"31-08-2024" => "19375259.1799",
	"30-09-2024" => "9955228.5485",
	"31-10-2024" => "17111089.2792",
	"30-11-2024" => "2798149.2848",
  ];
		$result = Correlation::r($currentLoopItems, $monthlySalesForSalesGathering);
		dd($result);
		

		// $study = Study::find(40);
		/**
		 * @var Study $study 
		 */
		// $studyDates = $study->getStudyDates() ;
		// $yearIndexWithYear = $study->getDatesIndexesHelper();
		// $operationDurationPerYear = $study->getOperationDurationPerYearFromIndexes();
		// dd($operationDurationPerYear);
		
		
		
		
		
		
		
		
		
		
		dd('d');

		$data = [
			"30-11-2021" => 79913.0,
    "31-12-2021" => 184174.75,
    "31-01-2022" => 70278.0001,
    "28-02-2022" => 35091.0,
    "31-03-2022" => 42909.5,
    "30-04-2022" => 29810.0,
    "31-05-2022" => 46345.0,
    "30-06-2022" => 73987.0,
    "31-07-2022" => 81380.0,
    "31-08-2022" => 85640.0001,
    "30-09-2022" => 55283.9998,
    "31-10-2022" => 101287.0,
    "30-11-2022" => 61524.0,
    "31-12-2022" => 219505.8,
    "31-01-2023" => 97392.2502,
    "28-02-2023" => 80794.6498,
    "31-03-2023" => 63703.2001,
    "30-04-2023" => 41386.0,
    "31-05-2023" => 97655.0001,
    "30-06-2023" => 109521.4999,
    "31-07-2023" => 77298.4999,
    "31-08-2023" => 105159.0002,
    "30-09-2023" => 104863.5001,
    "31-10-2023" => 118238.0001,
    "30-11-2023" => 159730.6055,
    "31-12-2023" => 224574.2198,
    "31-01-2024" => 150244.3162,
    "29-02-2024" => 137049.108,
    "31-03-2024" => 117330.3318,
    "30-04-2024" => 150199.8344,
    "31-05-2024" => 188480.0991,
    "30-06-2024" => 183932.3703,
    "31-07-2024" => 182787.535,
    // "31-08-2024" => 164545.7989,
    // "30-09-2024" => 150013.0997,
    // "31-10-2024" => 212250.8201,
    // "30-11-2024" => 129585.0402,
		];
		
		$actual  = [
			"30-11-2021" => 79913.0,
    "31-12-2021" => 184174.75,
    "31-01-2022" => 70278.0001,
    "28-02-2022" => 35091.0,
    "31-03-2022" => 42909.5,
    "30-04-2022" => 29810.0,
    "31-05-2022" => 46345.0,
    "30-06-2022" => 73987.0,
    "31-07-2022" => 81380.0,
    "31-08-2022" => 85640.0001,
    "30-09-2022" => 55283.9998,
    "31-10-2022" => 101287.0,
    "30-11-2022" => 61524.0,
    "31-12-2022" => 219505.8,
    "31-01-2023" => 97392.2502,
    "28-02-2023" => 80794.6498,
    "31-03-2023" => 63703.2001,
    "30-04-2023" => 41386.0,
    "31-05-2023" => 97655.0001,
    "30-06-2023" => 109521.4999,
    "31-07-2023" => 77298.4999,
    "31-08-2023" => 105159.0002,
    "30-09-2023" => 104863.5001,
    "31-10-2023" => 118238.0001,
    "30-11-2023" => 159730.6055,
    "31-12-2023" => 224574.2198,
    "31-01-2024" => 150244.3162,
    "29-02-2024" => 137049.108,
    "31-03-2024" => 117330.3318,
    "30-04-2024" => 150199.8344,
    "31-05-2024" => 188480.0991,
    "30-06-2024" => 183932.3703,
    "31-07-2024" => 182787.535,
    "31-08-2024" => 164545.7989,
    "30-09-2024" => 150013.0997,
    "31-10-2024" => 212250.8201,
    "30-11-2024" => 129585.0402,
		];  
		$actual = array_values($actual);
		$yHat =$this->forecastQualityValidation($data);
		// dd($yHat);
		$meanAbsoluteError = (new MeanAbsoluteError)->calculate($actual,$yHat);
		$meanAbsolutePercentageError=  (new MeanAbsolutePercentageError)->calculate($actual,$yHat);
		$rootMeanAbsolutePercentageError=  (new RootMeanSquaredPercentageError)->calculate($actual,$yHat);
		dd($meanAbsoluteError,$meanAbsolutePercentageError,$rootMeanAbsolutePercentageError);
		
	
	
	
	
		// $incomeStatement = IncomeStatement::find(350);
		/**
		 * @var IncomeStatement $incomeStatement
		 */
		
		// dd($incomeStatement->refreshCalculationFor('actual'));
		// dd($this->calculateSalesForecast());
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
	public function calculateIrr()
	{
		$pythonFilePath = resource_path('python/valuation/irr.py');
		$irr = json_encode([-1000, 200, 300, 400, 500]);
		$x = shell_exec('python3 '. $pythonFilePath .' '. $irr  );
		dd($x);
	}
	public function forecastQualityValidation(array $data)
	{
		$max = max($data) * 1.75;
		$dataFormatted = [];
		foreach($data as $date => $value){
			$year = Carbon::make($date)->format('Y');
			$month = Carbon::make($date)->format('m');
			$day = Carbon::make($date)->format('d');
			$date = $year . '-'.$month.'-'.$day;
			$dataFormatted['"ds"'][] = '"'.$date.'"' ;
			$dataFormatted['"y"'][] = $value ;
		}

		
		$pythonFilePath = resource_path('python/forecast/prophet_predicit.py');

		$dataFormatted = json_encode($dataFormatted);

		$x = shell_exec('python3 '. $pythonFilePath .' '. $dataFormatted  . ' ' . $max . ' ' . 4 );
		dd($x);
		preg_match('/\[(.*?)\]/s', $x, $matches);

	// Step 2: Remove any newlines and extra spaces
	$cleaned_data = preg_replace('/\s+/', ' ', $matches[1]);

	// Step 3: Split the cleaned data into an array of values
	$values = explode(' ', $cleaned_data);
	$values = collect($values)->filter(function($val){return is_numeric($val);})->values()->toArray();
	return $values ;
	}
	public function calculateSalesForecast()
	{
		$salesGathering = DB::table('sales_gathering')->where('company_id','=','105')
		->groupByRaw('year,month')
		->selectRaw('LAST_DAY(concat(year,"-",month,"-","01")) as date,sum(net_sales_value) as net_sales_value')
		->whereRaw("date between '2021-01-01' and '2024-11-30'")
		->orderByRaw('year asc,month asc')
		->get();
		$salesGatherFormatted=[];
		$dates =[]; 
		$salesValues = [];
		foreach($salesGathering as $salesItem){
			$day = explode('-',$salesItem->date)[2] ;
			$month = explode('-',$salesItem->date)[1] ;
			$year  = explode('-',$salesItem->date)[0];
			$salesGatherFormatted['"date"'][] ='"'. $year.'-'.$month.'-'.$day .'"';
			$dates[] = '"'. $year.'-'.$month.'-'.$day .'"' ;
			$salesGatherFormatted['"net_sales_value"'][] = $salesItem->net_sales_value ;
		//	$salesValues[] = $salesItem->net_sales_value ; 
		}
		$pythonFilePath = resource_path('python/forecast/sales-forecast.py');
		// $irr = json_encode([-1000, 200, 300, 400, 500]);
		// $x = shell_exec('python3 '. $pythonFilePath .' '. $irr  );
		$forecast = shell_exec('python3 '.$pythonFilePath .' ' . json_encode($salesGatherFormatted));
		dd($forecast);
	}
}
