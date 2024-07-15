<?php

namespace App\Console\Commands;

use App\Models\Cheque;
use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\CustomerInvoice;
use App\Models\Partner;
use App\Models\SupplierInvoice;
use App\Models\TablesField;
use App\Notifications\DueInvoiceNotification;
use Carbon\Carbon;	
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
		logger('pppppppppppppppppp');
		DB::table('debugging')->insert([
			'message'=>'ali'
		]);
		
		// foreach(Company::all() as $company){
		// 		CurrentAccountBankStatement::updateNonActiveDaily($company);
		// }
	}
}
