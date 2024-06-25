<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EmptyCashveroCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'empty:cashvero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty CashVero';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
		// dd( DB::connection()->getDoctrineSchemaManager()->listTableNames());
		foreach([
			'buy_or_sell_currencies',
			'cash_in_banks','cash_in_safes','cash_in_safe_statements',
			'cash_payments','certificates_of_deposits','cheques'
			// ,'supplier_invoices' ,'clean_overdrafts','customer_invoices','financial_institutions','financial_institution_accounts','fully_secured_overdrafts',''
			,'clean_overdraft_bank_statements','clean_overdraft_withdrawals',
			'current_account_bank_statements','debugging','down_payment_money_payment_settlements','down_payment_settlements','due_date_histories','fully_secured_overdraft_bank_statements','fully_secured_overdraft_withdrawals','incoming_transfers','internal_money_transfers','lc_facility_expenses','lc_hundred_percentage_cash_cover_opening_balances',
			"lc_facility_expenses"
, "lc_hundred_percentage_cash_cover_opening_balances"
, "lending_information"
, "lending_information_against_assignment_of_contracts"
, "letter_of_credit_cash_cover_statements"
, "letter_of_credit_facilities"
, "letter_of_credit_facility_term_and_conditions"
, "letter_of_credit_opening_balances"
, "letter_of_credit_statements"
, "letter_of_guarantee_cash_cover_statements"
, "letter_of_guarantee_facilities"
, "letter_of_guarantee_facility_term_and_conditions"
, "letter_of_guarantee_issuances"
, "letter_of_guarantee_opening_balances"
, "letter_of_guarantee_statements"
, "lg_against_td_or_cd_opening_balances"
, "lg_hundred_percentage_cash_cover_opening_balances"
, "lg_issuance_advanced_payment_histories"
, "lg_opening_balances"
, "loans",'opening_balances','outgoing_transfers',
'outstanding_breakdowns','overdraft_against_assignment_of_contract_bank_statements',
'overdraft_against_assignment_of_contract_limits','overdraft_against_assignment_of_contract_withdrawals',
'overdraft_against_commercial_paper_bank_statements','overdraft_against_commercial_paper_limits',
'overdraft_against_commercial_paper_withdrawals','payable_cheques',
'payment_settlements','settlements','money_received','money_payments','contracts'

		] as $tableName){
			
			DB::table($tableName)->delete();
		}
		
       
    }
}
