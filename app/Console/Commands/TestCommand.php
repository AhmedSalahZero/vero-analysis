<?php

namespace App\Console\Commands;

use App\Jobs\CheckDueAndPastedInvoicesJob;
use App\Models\Cheque;
use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Models\SupplierInvoice;
use App\Models\TablesField;
use App\Notifications\DueInvoiceNotification;
use Carbon\Carbon;	
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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
		$financialInstitution = FinancialInstitution::find(24);
		dd($financialInstitution->getAllAccountNumbers());
		dd('good');
	
		// $companyId = 85 ; 
		// $dateFormat = 'Y-m-d';
		// $pendingPayableChequeNotificationDays =3; 
		// $dayBeforeDayDate = Carbon::make(now()->format($dateFormat))->subDay()->format($dateFormat);
		
		// $beforeIntervalDate = Carbon::make(now()->format($dateFormat))->subDays($pendingPayableChequeNotificationDays)->format($dateFormat);
		// $pendingPayableCheques = PayableCheque::where('company_id', $companyId)
		// ->where('status',PayableCheque::PENDING)
		// ->whereBetween('due_date', [$beforeIntervalDate, $dayBeforeDayDate])->get();
		// dd($pendingPayableCheques,$beforeIntervalDate,$dayBeforeDayDate);
		// dd('e');
		// dd(getAllDataKey(['data-x'=>'x','ahmed'=>'salah','ee'=>'e']));
		CheckDueAndPastedInvoicesJob::dispatch();
		
		// echo 'salah helmy';
		logger('lllllllllllllllllll');
		echo getcwd();
		// foreach(Company::all() as $company){
		// 		CurrentAccountBankStatement::updateNonActiveDaily($company);
		// }
	}
}
