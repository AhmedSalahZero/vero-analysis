<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\Branch;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\FullySecuredOverdraft;
use App\Models\OverdraftAgainstCommercialPaper;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankStatementController
{
    use GeneralFunctions;

    public function index(Company $company)
    {
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$accountTypes = AccountType::onlyCashAccounts()->get();		
        return view('bank_statement_form', [
            'company' => $company,
            'financialInstitutionBanks' => $financialInstitutionBanks,
			'accountTypes'=>$accountTypes
        ]);
    }

    public function result(Company $company, Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $financialInstitutionId = $request->get('financial_institution_id');
		$financialInstitution = FinancialInstitution::find($financialInstitutionId);
		$financialInstitutionName = $financialInstitution->getName();
        $accountTypeId = $request->get('account_type');
        $accountNumber = $request->get('account_number');
        $currencyName = $request->get('currency');
		$results = [];
		$accountType = AccountType::find($accountTypeId);
		/**
		 * @var AccountType $accountType
		 */
		$accountTypeName = $accountType->getName() ;
		$isCurrentAccount = $accountType->isCurrentAccount() ;
		if($isCurrentAccount){
			$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber,$company->id,$financialInstitutionId);
			$results = DB::table('current_account_bank_statements')
			->where('date', '>=', $startDate)
			->where('date', '<=', $endDate)
			->where('current_account_bank_statements.financial_institution_account_id',$financialInstitutionAccount->id)
			->where('current_account_bank_statements.company_id',$company->id)
			->join('financial_institution_accounts','financial_institution_account_id','=','financial_institution_accounts.id')
			->where('currency',$currencyName)
			->where('current_account_bank_statements.date', '>=', $startDate)
			->where('current_account_bank_statements.date', '<', $endDate)
			->orderByRaw('current_account_bank_statements.full_date desc')
			->get();
			
			
		}
		elseif($accountType->isCleanOverDraftAccount()){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($accountNumber,$company->id,$financialInstitutionId);
			$results = DB::table('clean_overdraft_bank_statements')
				 ->where('clean_overdraft_bank_statements.company_id',$company->id)
				 ->where('date', '>=', $startDate)
				 ->where('date', '<=', $endDate)
				 ->where('clean_overdraft_id',$cleanOverdraft->id)
				 ->join('clean_overdrafts','clean_overdraft_bank_statements.clean_overdraft_id','=','clean_overdrafts.id')
				 ->where('clean_overdrafts.currency','=',$currencyName)
				 ->orderByRaw('full_date desc , priority asc ')
				 ->get();
		}
		elseif($accountType->isFullySecuredOverDraftAccount()){
			$fullySecuredOverdraft  = FullySecuredOverdraft::findByAccountNumber($accountNumber,$company->id,$financialInstitutionId);
			$results = DB::table('fully_secured_overdraft_bank_statements')
				 ->where('fully_secured_overdraft_bank_statements.company_id',$company->id)
				 ->where('date', '>=', $startDate)
				 ->where('date', '<=', $endDate)
				 ->where('fully_secured_overdraft_id',$fullySecuredOverdraft->id)
				 ->join('fully_secured_overdrafts','fully_secured_overdraft_bank_statements.fully_secured_overdraft_id','=','fully_secured_overdrafts.id')
				 ->where('fully_secured_overdrafts.currency','=',$currencyName)
				 ->orderByRaw('full_date desc , priority asc ')
				 ->get();
		}
		elseif($accountType->isOverDraftAgainstCommercialPaperAccount()){
			$overdraftAgainstCommercialPaper  = OverdraftAgainstCommercialPaper::findByAccountNumber($accountNumber,$company->id,$financialInstitutionId);
			$results = DB::table('overdraft_against_commercial_paper_bank_statements')
				 ->where('overdraft_against_commercial_paper_bank_statements.company_id',$company->id)
				 ->where('date', '>=', $startDate)
				 ->where('date', '<=', $endDate)
				 ->where('overdraft_against_commercial_paper_id',$overdraftAgainstCommercialPaper->id)
				 ->join('overdraft_against_commercial_papers','overdraft_against_commercial_paper_bank_statements.overdraft_against_commercial_paper_id','=','overdraft_against_commercial_papers.id')
				 ->where('overdraft_against_commercial_papers.currency','=',$currencyName)
				 ->orderByRaw('full_date desc , priority asc ')
				 ->get();
		}

        if (!count($results)) {
            return redirect()->back()->with('fail', __('No Data Found'));
        }

        return view('bank_statement_result', [
            'results' => $results,
            'currency' => $currencyName,
			'isCurrentAccount'=>$isCurrentAccount,
			'financialInstitutionName'=>$financialInstitutionName,
			'accountTypeName'=>$accountTypeName,
			'accountNumber'=>$accountNumber
        ]);
    }
}
