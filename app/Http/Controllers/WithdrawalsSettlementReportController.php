<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalsSettlementReportController
{
	const NUMBER_OF_INTERNAL_MONTHS = 6 ;
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
	public function refreshReport(Company $company,Request $request) // ajax 
	{
		$accountTypeId = $request->get('accountTypeId');
		$currencyName = $request->get('currencyName');
		$startDate = now()->format('Y-m-d');
		$endDate = Carbon::make($startDate)->addMonths(self::NUMBER_OF_INTERNAL_MONTHS)->format('Y-m-d');
		$financialInstitutionIds = $company->financialInstitutions->pluck('id')->toArray();
		$overdraftWithdrawals = $this->getOverdraftWithdrawalsWithoutStartDate( $endDate,$currencyName,$accountTypeId ,$company->id, $financialInstitutionIds);
		$overdraftWithdrawals = $overdraftWithdrawals->take(6);

		return response()->json([
			'status'=>true ,
			'data'=>$overdraftWithdrawals
		]);
	}
	protected function getOverdraftWithdrawals( string $startDate ,  string $endDate , string $currency   , int $accountTypeId , int $companyId , array $financialInstitutionIds  )
	{
		$accountType = AccountType::find($accountTypeId);
		$fullClassName = ('\App\Models\\'.$accountType->model_name) ;
		$overdraftIds = $fullClassName::findByFinancialInstitutionIds($financialInstitutionIds);
		$foreignKeyName = $fullClassName::generateForeignKeyFormModelName();
		$withdrawalsTableName = $fullClassName::getWithdrawalTableName();
		$bankStatementTableName = $fullClassName::getBankStatementTableName();
		$bankStatementIdName = $fullClassName::getBankStatementIdName();
		
		$tableName = (new $fullClassName)->getTable();
		return DB::table($withdrawalsTableName)
		->join($bankStatementTableName,$bankStatementIdName,'=',$bankStatementTableName.'.id')
		->join($tableName,$bankStatementTableName.'.'.$foreignKeyName,'=',$tableName.'.id')
		->join('financial_institutions','financial_institutions.id','=',$tableName.'.financial_institution_id')
		->join('banks','banks.id','=','financial_institutions.bank_id')
		->where($bankStatementTableName.'.company_id',$companyId)
		->whereIn($bankStatementTableName.'.'.$foreignKeyName,$overdraftIds)
		->whereBetween($bankStatementTableName.'.date',[$startDate,$endDate] )
		->where('currency',$currency)
		->orderByRaw('due_date asc')
		->get();
	}
	protected function getOverdraftWithdrawalsWithoutStartDate(  string $endDate , string $currency   , int $accountTypeId , int $companyId , array $financialInstitutionIds  )
	{
		$accountType = AccountType::find($accountTypeId);
		$fullClassName = ('\App\Models\\'.$accountType->model_name) ;
		$overdraftIds = $fullClassName::findByFinancialInstitutionIds($financialInstitutionIds);
		$foreignKeyName = $fullClassName::generateForeignKeyFormModelName();
		$withdrawalsTableName = $fullClassName::getWithdrawalTableName();
		$bankStatementTableName = $fullClassName::getBankStatementTableName();
		$bankStatementIdName = $fullClassName::getBankStatementIdName();
		
		$tableName = (new $fullClassName)->getTable();
		return DB::table($withdrawalsTableName)
		->join($bankStatementTableName,$bankStatementIdName,'=',$bankStatementTableName.'.id')
		->join($tableName,$bankStatementTableName.'.'.$foreignKeyName,'=',$tableName.'.id')
		->join('financial_institutions','financial_institutions.id','=',$tableName.'.financial_institution_id')
		->join('banks','banks.id','=','financial_institutions.bank_id')
		->where($bankStatementTableName.'.company_id',$companyId)
		->whereIn($bankStatementTableName.'.'.$foreignKeyName,$overdraftIds)
		->where($bankStatementTableName.'.date','<=',$endDate )
		->where('currency',$currency)
		->orderByRaw('due_date asc')
		->get();
	}
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
		$endDate  = $request->get('end_date');
		$currency = $request->get('currency');
		$financialInstitutionIds = $request->get('financial_institution_ids',[]);
		$accountTypeId = $request->get('account_type') ;
		$accountType = AccountType::find($accountTypeId);
		$fullClassName = ('\App\Models\\'.$accountType->model_name) ;
		$tableNameFormatted = $fullClassName::getTableNameFormatted();
		// dd('qqq');
		$overdraftWithdrawals = $this->getOverdraftWithdrawals($startDate, $endDate,$currency,$accountTypeId ,$company->id, $financialInstitutionIds);

	
		return view('withdrawal_settlement_report_result',[
			'overdraftWithdrawals'=>$overdraftWithdrawals,
			'tableNameFormatted'=>$tableNameFormatted
		]);
	}
	


}
