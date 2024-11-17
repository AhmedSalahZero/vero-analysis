<?php

namespace App\Console\Commands;


use App\Models\MoneyReceived;
use App\Models\Settlement;
use App\Models\TimeOfDeposit;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use KitLoong\MigrationsGenerator\Setting;
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
		dd(hasExport(['date','country','q'],40));
		
		///////////////////////////
		$url = 'itechs-testing.odoo.com';
		$db = 'ahmednabil1975-itechs-project-testing-15573994';
		$username = "test@test.com";
		$password = "1234567";
		require_once(public_path('apis/ripcord.php'));
		$info = ripcord::client('https://demo.odoo.com/start')->start();
		$res = list($url, $db, $username, $password) = array($info['host'], $info['database'], $info['user'], $info['password']);
		
		$common = ripcord::client("$url/xmlrpc/2/common");
		$res=$common->version();
		$uid = $common->authenticate($db, $username, $password, array());
		$models = ripcord::client("$url/xmlrpc/2/object");
		
		$ids=$models->execute_kw($db, $uid, $password, 'res.partner', 'search',array(array(array('is_company', '=', true))), array('limit' => 10));
		$records = $models->execute_kw($db, $uid, $password, 'account.move', 'read', array($ids));
		// $records = $models->execute_kw($db, $uid, $password, 'res.partner', 'read', array($ids));

		// dd($records[0]);
		// $this->refreshStatement('CustomerInvoice','created_at');
		// $this->refreshStatement('SupplierInvoice','created_at');
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
