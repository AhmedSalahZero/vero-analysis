<?php

namespace App\Console\Commands;

use App\Jobs\CheckDueAndPastedInvoicesJob;
use App\Models\CashExpense;
use App\Models\Cheque;
use App\Models\CleanOverdraft;
use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\LoanSchedule;
use App\Models\MediumTermLoan;
use App\Models\MoneyPayment;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Models\SupplierInvoice;
use App\Models\TablesField;
use App\Notifications\DueInvoiceNotification;
use Carbon\Carbon;	
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
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
		
		foreach(['cash_vero_branches'] as $mainTableName){
			Schema::create($mainTableName,function(Blueprint $table){
				$table->id();
				$table->string('name');
				$table->unsignedBigInteger('company_id');
				$table->timestamps();
			});
		}
		
	// 	$x = DB::table('customer_invoices')->pluck('company_id')->unique()->values()->toArray();
	// 	$y = ['ahmed','mohamed'] ;
		
	// ;	dd(array_map(function($item){
	// 	return ['x'=>$item,'y'=>5];
	// },$y));
		
		// dd($result);
		// $arr = collect([
		// 	true ? 'ahmed' : false ,
		// 	true ? 'salah' : false,
		// 	false ? 'khaled' : false  ,
		// ])->filter(function($value){return $value;})->toArray() ;
		// dd($arr);
		// DB::table('permissions')->delete();
		// DB::table('model_has_permissions')->delete();
		// DB::table('role_has_permissions')->delete();
		// app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
		// app()->make(\Spatie\Permission\PermissionRegistrar::class)->clearClassPermissions();
		
	}
}
