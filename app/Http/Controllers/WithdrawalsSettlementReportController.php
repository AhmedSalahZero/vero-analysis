<?php

namespace App\Http\Controllers;

use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalsSettlementReportController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyHasOverdrafts()->get();
        return view('reports.withdrawals_settlement_report_form', [
			'company'=>$company,
			'financialInstitutionBanks'=>$financialInstitutionBanks
		]);
    }
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
		$currency = $request->get('currency');
		$endDate  = $request->get('end_date');
		$financialInstitutionIds = $request->get('financial_institution_ids',[]);
		$cleanOverdraftIds = CleanOverdraft::findByFinancialInstitutionIds($financialInstitutionIds);
		$cleanOverdraftWithdrawals=DB::table('clean_overdraft_withdrawals')
		->join('clean_overdraft_bank_statements','clean_overdraft_bank_statement_id','=','clean_overdraft_bank_statements.id')
		->join('clean_overdrafts','clean_overdraft_bank_statements.clean_overdraft_id','=','clean_overdrafts.id')
		->join('financial_institutions','financial_institutions.id','=','clean_overdrafts.financial_institution_id')
		->join('banks','banks.id','=','financial_institutions.bank_id')
		->where('clean_overdraft_bank_statements.company_id',$company->id)
		->whereIn('clean_overdraft_bank_statements.clean_overdraft_id',$cleanOverdraftIds)
		->whereBetween('clean_overdraft_bank_statements.date',[$startDate,$endDate] )
		->orderByRaw('due_date asc')
		->get();
		return view('withdrawal_settlement_report_result',[
			'clean_overdraft_withdrawals'=>$cleanOverdraftWithdrawals
		]);
	}
	


}
