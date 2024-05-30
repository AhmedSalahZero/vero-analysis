<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
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
		$accountTypes = AccountType::onlyOverdraftsAccounts()->get();
		
        return view('reports.withdrawals_settlement_report_form', [
			'company'=>$company,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes
		]);
    }
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
		$currency = $request->get('currency');
		$endDate  = $request->get('end_date');
		$financialInstitutionIds = $request->get('financial_institution_ids',[]);
		$accountType = AccountType::find($request->get('account_type'));
		$fullClassName = ('\App\Models\\'.$accountType->model_name) ;
		$overdraftIds = $fullClassName::findByFinancialInstitutionIds($financialInstitutionIds);
		$foreignKeyName = $fullClassName::generateForeignKeyFormModelName();
		$withdrawalsTableName = $fullClassName::getWithdrawalTableName();
		$bankStatementTableName = $fullClassName::getBankStatementTableName();
		$bankStatementIdName = $fullClassName::getBankStatementIdName();
		$tableNameFormatted = $fullClassName::getTableNameFormatted();
		$tableName = (new $fullClassName)->getTable();
		
		$overdraftWithdrawals=DB::table($withdrawalsTableName)
		->join($bankStatementTableName,$bankStatementIdName,'=',$bankStatementTableName.'.id')
		->join($tableName,$bankStatementTableName.'.'.$foreignKeyName,'=',$tableName.'.id')
		->join('financial_institutions','financial_institutions.id','=',$tableName.'.financial_institution_id')
		->join('banks','banks.id','=','financial_institutions.bank_id')
		->where($bankStatementTableName.'.company_id',$company->id)
		->whereIn($bankStatementTableName.'.'.$foreignKeyName,$overdraftIds)
		->whereBetween($bankStatementTableName.'.date',[$startDate,$endDate] )
		->orderByRaw('due_date asc')
		->get();
	
		return view('withdrawal_settlement_report_result',[
			'cleanOverdraftWithdrawals'=>$overdraftWithdrawals,
			'tableNameFormatted'=>$tableNameFormatted
		]);
	}
	


}
