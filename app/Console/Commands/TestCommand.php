<?php

namespace App\Console\Commands;

use App\Jobs\CheckDueAndPastedInvoicesJob;
use App\Models\CashExpense;
use App\Models\Cheque;
use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\MoneyPayment;
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
		$mainTableName = 'outgoing_transfers';
		$subTableName ='cash_expenses';
		$companyId=  41;
		$dateFieldName = 'payment_date';
		$moneyType = CashExpense::OUTGOING_TRANSFER;
		$startDate = '2024-01-01';
		$endDate = '2024-12-31';
		
		$mainCashExpenseCategoryNameWithPaidAmount = DB::table($mainTableName)
						->where($subTableName.'.currency','EGP')
						->where('type',$moneyType)
						->where($subTableName.'.company_id',$companyId)
						->whereBetween($dateFieldName,[$startDate,$endDate])
						->join($subTableName,$subTableName.'.id','=','cash_expense_id')
						->join('cash_expense_category_names',$subTableName.'.cash_expense_category_name_id','=','cash_expense_category_names.id')
						->join('cash_expense_categories','cash_expense_category_id','=','cash_expense_categories.id')
					
						->groupBy('cash_expense_category_name_id')
						->selectRaw('cash_expense_categories.name as category_name , cash_expense_category_names.name as expense_name ,sum(paid_amount) as paid_amount')->get();
					dd($mainCashExpenseCategoryNameWithPaidAmount);	
		$result = DB::table('outgoing_transfers')
						->where('money_payments.currency','EGP')
						->where('type',MoneyPayment::OUTGOING_TRANSFER)
						->where('money_payments.company_id',41)
						->whereBetween('delivery_date',['2024-01-01','2024-12-31'])
						->join('money_payments','money_payments.id','=','money_payment_id')
						->groupBy('supplier_name')
						->selectRaw('supplier_name,sum(paid_amount) as paid_amount')->get();
						
	}
}
