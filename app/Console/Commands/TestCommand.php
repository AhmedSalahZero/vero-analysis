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
		
		$url = 'https://itechs-training.odoo.com';
		$db = 'ahmednabil1975-itechs-project-newtest-16243928';
		$username = "test@test.com";
		$password = "1234567";
		require_once(public_path('apis/ripcord.php'));
		$common = ripcord::client("$url/xmlrpc/2/common");
		$uid = $common->authenticate($db, $username, $password, array());
		$models = ripcord::client("$url/xmlrpc/2/object");
		
				$fields = [
					'partner_id',
		'id',
		'invoice_date',
		'name',
		'move_type',
		'currency_id',
		'amount_total',
		'amount_residual',
		'amount_total_signed',
		'amount_tax',
		'invoice_date_due',
				];
		$filter = array(array(array('move_type', 'in', [
			'in_invoice'
		,
		'out_invoice'
	]),array('state', '=', 'posted')));
		$ids=$models->execute_kw($db, $uid, $password, 'account.move', 'search',$filter, array('limit' => 10));
		$records = $models->execute_kw($db, $uid, $password, 'account.move', 'read', array($ids),[
			'fields'=>$fields
		]);
		dd($records);
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
