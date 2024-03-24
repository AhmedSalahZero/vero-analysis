<?php

namespace App\Console\Commands;

use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\MoneyReceived;
use App\Models\OpeningBalance;
use App\Models\SalesForecast;
use App\Models\SalesGathering;
use App\Services\Caching\CashingService;
use App\Services\Caching\CustomerDashboardCashing;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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
		$openingBalance = OpeningBalance::find(18);
		dd($openingBalance->chequeInSafe);
		// $item = CleanOverdraftBankStatement::where('id',3)->first();
		// $item->delete();
		///////////////////
		// $item = CleanOverdraftBankStatement::where('id',3)->first();
		// $item->clean_overdraft_id = 2 ;
		// $item->debit = 0 ;
		// $item->save();
		
		
dd('good');		
		
		// CleanOverdraftBankStatement::where('id','>=',2)->each(function($item){
		// 	$debit = $item->id ==3  ? 100 : $item->debit ;
		// 	$item->update([
		// 		'updated_at'=>now(),
		// 		'debit'=>$debit
		// 	]);
		// });
		// dd('good');
	}
}
