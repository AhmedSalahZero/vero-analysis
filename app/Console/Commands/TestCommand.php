<?php

namespace App\Console\Commands;

use App\Models\MoneyReceived;
use App\Models\Settlement;
use App\Models\TimeOfDeposit;
use Carbon\Carbon;
use function Ramsey\Uuid\v1;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use KitLoong\MigrationsGenerator\Setting;
use Phpml\Metric\ClassificationReport;
use Phpml\Regression\LeastSquares;
use Phpml\Regression\MLPRegressor;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use ripcord;

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
		$samples = [[60], [61], [62], [63], [65]];
$targets = [3.1, 3.6, 3.8, 4, 4.1];

$regression = new SVR(Kernel::LINEAR);
$regression->train($samples, $targets);
$val=$regression->predict([64]);
dd($val);


		// Predict a value
		// $salesData = [
		// 	['timestamp' => [strtotime('2024-05-31')], 'total_sales' => [85]],
		// 	['timestamp' => [strtotime('2024-04-30')], 'total_sales' => [38]],
		// 	['timestamp' => [strtotime('2024-03-31')], 'total_sales' => [25]],
		// 	['timestamp' => [strtotime('2024-02-28')], 'total_sales' => [15]],
		// 	['timestamp' => [strtotime('2024-01-31')], 'total_sales' => [20]],
		// 	// ['timestamp' => [strtotime('2024-03-01')], 'total_sales' => [30]],
		// ];
		// // dd($salesData);
		// // Extract timestamps and sales values
		// $timestamps = array_column($salesData, 'timestamp');
		// $sales = array_column($salesData, 'total_sales');
		
		// // Train the regression model
		// $regression = new LeastSquares();
		// $regression->train($timestamps,$sales);
		// // Predict future sales for December 1, 2024
		// $futureTimestamp = strtotime('2024-06-30');
		// $predictedSales = $regression->predict([$futureTimestamp]);
		// dd(round($predictedSales));
		// echo "Predicted Sales for 2024-12-01: " . round($predictedSales) . "\n";
		
// 		$url = 'https://itechs-training.odoo.com';
// 		$db = 'ahmednabil1975-itechs-project-newtest-16243928';
// 		$username = "test@test.com";
// 		$password = "1234567";
// 		require_once(public_path('apis/ripcord.php'));
// 		$common = ripcord::client("$url/xmlrpc/2/common");
// 		$uid = $common->authenticate($db, $username, $password, array());
// 		$models = ripcord::client("$url/xmlrpc/2/object");
		
		// 		$fields = [
		// 			'partner_id',
		// 'id',
		// 'invoice_date',
		// 'name',
		// 'move_type',
		// 'currency_id',
		// 'amount_total',
		// 'amount_residual',
		// 'amount_total_signed',
		// 'amount_tax',
		// 'invoice_date_due',
		// 		];
// 		$filter = array(array(array('move_type', 'in', [
// 			'in_invoice'
// 		,
// 		'out_invoice'
// 	]),array('state', '=', 'posted')));
// 		$ids=$models->execute_kw($db, $uid, $password, 'account.move', 'search',$filter, array('limit' => 10));
// 		$records = $models->execute_kw($db, $uid, $password, 'account.move', 'read', array($ids),[
// 			'fields'=>$fields
// 		]);
// 		dd($records);
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
