<?php

namespace App\Http\Controllers;
use App\Enums\LcTypes;
use App\Enums\LgTypes;
use App\Helpers\HArr;
use App\Helpers\HDate;
use App\Http\Controllers\CashFlowReportController;
use App\Http\Controllers\WithdrawalsSettlementReportController;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\CashInSafeStatement;
use App\Models\CertificatesOfDeposit;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\FullySecuredOverdraft;
use App\Models\LetterOfCreditIssuance;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\MediumTermLoan;
use App\Models\OverdraftAgainstCommercialPaper;
use App\Models\Partner;
use App\Models\TimeOfDeposit;
use App\ReadyFunctions\ChequeAgingService;
use App\ReadyFunctions\InvoiceAgingService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CustomerInvoiceDashboardController extends Controller
{
    public function viewCashDashboard(Company $company, Request $request)
    {
			// start fully SecuredOverdraft
			$mediumTermLoansArr = [];
			$allFullySecuredOverdraftBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->onlyHasFullySecuredOverdrafts()->get();
			$fullySecuredOverdraftAccountTypes = AccountType::onlyFullySecuredOverdraft()->get();
			$fullySecuredOverdraftCardData = [];
			$cdAccountTypeId = AccountType::onlyCdAccounts()->first()->id ;
			$tdAccountTypeId = AccountType::onlyTdAccounts()->first()->id ;
			
			
			$totalRoomForEachFullySecuredOverdraftId =  [];
			// end fully SecuredOverdraft
			
		// start cleanOverdraft
		 
		$allCleanOverdraftBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->onlyHasCleanOverdrafts()->get();
		$cleanOverdraftAccountTypes = AccountType::onlyCleanOverdraft()->get();
        $cleanOverdraftCardData = [];
		$totalRoomForEachCleanOverdraftId =  [];
        // end cleanOverdraft
		
		
		// start overdraft Against Commercial Paper
		 
		$allOverdraftAgainstCommercialPaperBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->onlyHasOverdraftAgainstCommercialPapers()->get();
		$overdraftAgainstCommercialPaperAccountTypes = AccountType::onlyOverdraftAgainstCommercialPaper()->get();
        $overdraftAgainstCommercialPaperCardData = [];
		$totalRoomForEachOverdraftAgainstCommercialPaperId =  [];
        // end overdraftAgainstCommercialPaper
		
		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$financialInstitutionBankIds = $financialInstitutionBanks->pluck('id')->toArray();
		$selectedFinancialInstitutionBankIds = $request->has('financial_institution_ids') ? $request->get('financial_institution_ids') : $financialInstitutionBankIds ;
		$currentDate = now()->format('Y-m-d') ;
        $date = $request->get('date');
		$date = $date ? HDate::formatDateFromDatePicker($date) : $currentDate;
		$year = explode('-',$date)[0];
		$date = Carbon::make($date)->format('Y-m-d');
		$allCurrencies = getCurrenciesForSuppliersAndCustomers($company->id) ;
	
		$details = [];
		
		
		
        $selectedCurrencies = $request->get('currencies', $allCurrencies) ;
        $reports = [];
		
		$totalCard = [];
        foreach ($selectedCurrencies as $currencyName) {
			$loansForCurrentCurrency = MediumTermLoan::where('currency',$currencyName)->with(['loanSchedules'])->where('company_id',$company->id)->get() ;
			$mediumTermLoansArr[$currencyName] = $loansForCurrentCurrency;
			$currentAccountInBanks = 0 ;
			$totalCertificateOfDepositsForCurrentFinancialInstitutionAmount = 0 ;
            $totalTimeDepositsForCurrentFinancialInstitutionAmount = 0 ;
			$cashInSafeStatementAmountForCurrency = 0 ;
			foreach(Branch::getBranchesForCurrentCompany($company->id) as $currentBranchId => $currentBranchName){
				$cashInSafeStatementAmountForCurrencyAndBranch = CashInSafeStatement::
				where('date', '<=', $date)
				->where('company_id', $company->id)
				->where('currency', $currencyName)
				->where('branch_id',$currentBranchId)
				->orderByRaw('full_date desc')->limit(1)->first();
				$details[$currencyName]['cash_in_safe'][] = [
					'amount'=>$currentBranchEndBalanceForCurrency=$cashInSafeStatementAmountForCurrencyAndBranch ? $cashInSafeStatementAmountForCurrencyAndBranch->end_balance : 0 ,
					'branch_name'=>$currentBranchName,
				] ;
				$cashInSafeStatementAmountForCurrency += $currentBranchEndBalanceForCurrency;
			}
			
			
			// start fully secured overdraft
			$totalFullySecuredOverdraftRoom = 0 ;
			$fullySecuredOverdraftCardCommonQuery = FullySecuredOverdraft::getCommonQueryForCashDashboard($company,$currencyName,$date);
			$fullySecuredOverdraftIds = $fullySecuredOverdraftCardCommonQuery->pluck('id')->toArray() ;
			$hasFullySecuredOverdraft[$currencyName] = FullySecuredOverdraft::hasAnyRecord($company,$currencyName); 
			// end fully secured Overdraft
			
			// start clean overdraft
			$totalCleanOverdraftRoom = 0 ;
			$cleanOverdraftCardCommonQuery = CleanOverdraft::getCommonQueryForCashDashboard($company,$currencyName,$date);
			$cleanOverdraftIds = $cleanOverdraftCardCommonQuery->pluck('id')->toArray() ;
			$hasCleanOverdraft[$currencyName] = CleanOverdraft::hasAnyRecord($company,$currencyName);
			// end clean Overdraft
			
			
			
			// start clean overdraft
			$totalOverdraftAgainstCommercialPaperRoom = 0 ;
			$overdraftAgainstCommercialPaperCardCommonQuery = OverdraftAgainstCommercialPaper::getCommonQueryForCashDashboard($company,$currencyName,$date);
			$overdraftAgainstCommercialPaperIds = $overdraftAgainstCommercialPaperCardCommonQuery->pluck('id')->toArray() ;
			$hasOverdraftAgainstCommercialPaper[$currencyName] = OverdraftAgainstCommercialPaper::hasAnyRecord($company,$currencyName);
			// end clean Overdraft
			
			
			
			
			
   
            
            foreach ($selectedFinancialInstitutionBankIds as $financialInstitutionBankId) {
				$currentFinancialInstitution = FinancialInstitution::find($financialInstitutionBankId);
				$financialInstitutionName = $currentFinancialInstitution->getName();
				
				/**
				 * * start clean overdraft
				 */
				CleanOverdraft::getCashDashboardDataForFinancialInstitution($totalRoomForEachCleanOverdraftId,$company,$cleanOverdraftIds,$currencyName,$date,$financialInstitutionBankId,$totalCleanOverdraftRoom);
				/**
				 * * end clean overdraft
				 */
				
				 
				/**
				 * * start fully Secured overdraft
				 */
				FullySecuredOverdraft::getCashDashboardDataForFinancialInstitution($totalRoomForEachFullySecuredOverdraftId,$company,$fullySecuredOverdraftIds,$currencyName,$date,$financialInstitutionBankId,$totalFullySecuredOverdraftRoom);
				 /**
				  * * end fully Secured overdraft
				  */
		

        	/**
				 * * start overdraft against commercial paper
				 */
				OverdraftAgainstCommercialPaper::getCashDashboardDataForFinancialInstitution($totalRoomForEachOverdraftAgainstCommercialPaperId,$company,$overdraftAgainstCommercialPaperIds,$currencyName,$date,$financialInstitutionBankId,$totalOverdraftAgainstCommercialPaperRoom);
				/**
				 * * end overdraft against commercial paper
				 */
		
				 
				
                /**
                 * * حساب ال current account
                 */
				$allAccountNumbersForThisCurrencyAndFinancialInstitution = FinancialInstitutionAccount::getAllAccountNumberForCurrency($company->id,$currencyName,$financialInstitutionBankId,true);
				foreach($allAccountNumbersForThisCurrencyAndFinancialInstitution as $currentAccountNumber){
					$currentAccountEndBalanceForCurrency = DB::table('current_account_bank_statements')
                ->join('financial_institution_accounts', 'financial_institution_account_id', '=', 'financial_institution_accounts.id')
                ->where('financial_institution_accounts.company_id', $company->id)
                ->where('currency', $currencyName)
                ->where('date', '<=', $date)
				->where('account_number',$currentAccountNumber)
                ->where('financial_institution_accounts.financial_institution_id', '=', $financialInstitutionBankId)
                ->orderBy('current_account_bank_statements.full_date', 'desc')
                ->limit(1)
                ->first();

		
				
		
					$details[$currencyName]['current_account'][] = [
						'amount'=>$currentAmount = $currentAccountEndBalanceForCurrency ? $currentAccountEndBalanceForCurrency->end_balance : 0 ,
						'account_number'=>$currentAccountNumber,
						'financial_institution_name'=>$currentFinancialInstitution->getName()
					] ;

             	   $currentAccountInBanks += $currentAmount ;
				}

                

                /**
                 * * حساب certificates_of_deposits
                 */
                $certificateOfDepositsForCurrentFinancialInstitution = DB::table('certificates_of_deposits')
				->where('certificates_of_deposits.company_id', $company->id)
				->where('certificates_of_deposits.status',CertificatesOfDeposit::RUNNING)
				->where('certificates_of_deposits.financial_institution_id', $financialInstitutionBankId)
				->where('certificates_of_deposits.currency', $currencyName)
				
				->leftJoin('fully_secured_overdrafts',function($q) use($cdAccountTypeId) {
					$q->on('fully_secured_overdrafts.cd_or_td_account_id','=','certificates_of_deposits.account_number')->where('fully_secured_overdrafts.cd_or_td_account_type_id',$cdAccountTypeId);
				})
				->leftJoin('letter_of_guarantee_issuances',function($q) use($cdAccountTypeId) {
					$q->on('letter_of_guarantee_issuances.cd_or_td_account_number','=','certificates_of_deposits.account_number')->where('letter_of_guarantee_issuances.cd_or_td_account_type_id',$cdAccountTypeId);
				})
				/**
				 * ! مؤجلة لحين الانتهاء من جدول ال 
				 * ! credit issuance
				 */
				// ->leftJoin('letter_of_credit_issuances',function($q) use($cdAccountTypeId) {
				// 	$q->on('letter_of_credit_issuances.cd_or_td_account_number','=','certificates_of_deposits.account_number')->where('letter_of_credit_issuances.cd_or_td_account_type_id',$cdAccountTypeId);
				// })
				
				->orderBy('certificates_of_deposits.end_date', 'desc')
				
				->selectRaw(' "'. $financialInstitutionName .'" as financial_institution_name , certificates_of_deposits.account_number as account_number,certificates_of_deposits.amount as amount, case 
					when letter_of_guarantee_issuances.cash_cover_deducted_from_account_type = '.$cdAccountTypeId .' then "' .  __('LG') 
				.'" when letter_of_guarantee_issuances.cd_or_td_account_type_id = '.$cdAccountTypeId .' then "' .  __('LG') 
				.'" when fully_secured_overdrafts.cd_or_td_account_type_id = '.$cdAccountTypeId .' then "'.  __('Overdraft') 
				
				/**
				 * ! مؤجلة لحين الانتهاء من جدول ال 
				 * ! credit issuance
				 */
				// .'" when letter_of_credit_issuances.cd_or_td_account_type_id = '.$tdAccountTypeId .' then "' .  __('LC') 
				.
				'"  else "'. __('Free To Use') .'" end as blocked')
				->get();
				// $certificateOfDepositsForCurrentFinancialInstitutionDetails = $this->getKeysFromStdClass($certificateOfDepositsForCurrentFinancialInstitution,['account_number','amount'],['financial_institution_name'=>$currentFinancialInstitution->getName()]);
				foreach($certificateOfDepositsForCurrentFinancialInstitution as $certificateOfDepositsForCurrentFinancialInstitutionDetail){
					$details[$currencyName]['certificate_of_deposits'][] = (array)$certificateOfDepositsForCurrentFinancialInstitutionDetail ;
				}
				
				
				
				
                $totalCertificateOfDepositsForCurrentFinancialInstitutionAmount += $certificateOfDepositsForCurrentFinancialInstitution ? $certificateOfDepositsForCurrentFinancialInstitution->sum('amount') : 0;
				
				
				
				

				$timeDepositsForCurrentFinancialInstitution = DB::table('time_of_deposits')
				->where('time_of_deposits.company_id', $company->id)
				->where('time_of_deposits.status',TimeOfDeposit::RUNNING)
				->where('time_of_deposits.financial_institution_id', $financialInstitutionBankId)
				->where('time_of_deposits.currency', $currencyName)
				->leftJoin('fully_secured_overdrafts',function($q) use($tdAccountTypeId) {
					$q->on('fully_secured_overdrafts.cd_or_td_account_id','=','time_of_deposits.account_number')->where('fully_secured_overdrafts.cd_or_td_account_type_id',$tdAccountTypeId);
				})
				->leftJoin('letter_of_guarantee_issuances',function($q) use($tdAccountTypeId) {
					$q->on('letter_of_guarantee_issuances.cd_or_td_account_number','=','time_of_deposits.account_number')->where('letter_of_guarantee_issuances.cd_or_td_account_type_id',$tdAccountTypeId);
				})
				/**
				 * ! مؤجلة لحين الانتهاء من جدول ال 
				 * ! credit issuance
				 */
				// ->leftJoin('letter_of_credit_issuances',function($q) use($tdAccountTypeId) {
				// 	$q->on('letter_of_credit_issuances.cd_or_td_account_number','=','time_of_deposits.account_number')->where('letter_of_credit_issuances.cd_or_td_account_type_id',$tdAccountTypeId);
				// })
				->orderBy('time_of_deposits.end_date', 'desc')
				->selectRaw(' "'. $financialInstitutionName .'" as financial_institution_name , time_of_deposits.account_number as account_number,time_of_deposits.amount as amount, case 
				when letter_of_guarantee_issuances.cash_cover_deducted_from_account_type = '.$tdAccountTypeId .' then "' .  __('LG') 
				.'" when letter_of_guarantee_issuances.cd_or_td_account_type_id = '.$tdAccountTypeId .' then "' .  __('LG') 
				.'" when fully_secured_overdrafts.cd_or_td_account_type_id = '.$tdAccountTypeId .' then "'.  __('Overdraft') 
				
				/**
				 * ! مؤجلة لحين الانتهاء من جدول ال 
				 * ! credit issuance
				 */
				// .'" when letter_of_credit_issuances.cd_or_td_account_type_id = '.$tdAccountTypeId .' then "' .  __('LC') 
				.
				'"  else "'. __('Free To Use') .'" end as blocked')
				->get();
				;	
			
				foreach($timeDepositsForCurrentFinancialInstitution as $timeDepositsForCurrentFinancialInstitutionDetail){
					$details[$currencyName]['time_of_deposits'][] = (array)$timeDepositsForCurrentFinancialInstitutionDetail ;
				}
			
				$timeDepositsForCurrentFinancialInstitutionAmount = $timeDepositsForCurrentFinancialInstitution->sum('amount');
				
		
                $totalTimeDepositsForCurrentFinancialInstitutionAmount += $timeDepositsForCurrentFinancialInstitutionAmount ? $timeDepositsForCurrentFinancialInstitutionAmount : 0;
               
			




                /**
                 * * حساب ال clean_overdraft
                 * * مؤجلة لحساب الكلين اوفردرافت
                 * * against commercial
                 */
                //   $cleanOverdraftOverCommercialRoom = DB::table('overdraft_against_commercial_paper_bank_statements')
                //   ->where('overdraft_against_commercial_paper_bank_statements.company_id',$company->id)->where('date','<=',$date)
                //   ->join('overdraft_against_commercial_papers','overdraft_against_commercial_paper_bank_statements.overdraft_against_commercial_paper_id','=','overdraft_against_commercial_papers.id')
                //   ->where('overdraft_against_commercial_papers.currency','=',$currencyName)
                //   ->orderBy('overdraft_against_commercial_paper_bank_statements.id')
                //   ->limit(1)
                //   ->first() ;
                //   $cleanOverdraftOverCommercialRoom = $cleanOverdraftOverCommercialRoom ? $cleanOverdraftOverCommercialRoom->room : 0 ;
                //   $totalCleanOverdraftAgainstCommercialRoom +=$cleanOverdraftOverCommercialRoom ;
            }
			CleanOverdraft::getCashDashboardDataForYear($cleanOverdraftCardData,$cleanOverdraftCardCommonQuery,$company,$cleanOverdraftIds,$currencyName,$date,$year);
			FullySecuredOverdraft::getCashDashboardDataForYear($fullySecuredOverdraftCardData,$fullySecuredOverdraftCardCommonQuery,$company,$fullySecuredOverdraftIds,$currencyName,$date,$year);
			OverdraftAgainstCommercialPaper::getCashDashboardDataForYear($overdraftAgainstCommercialPaperCardData,$overdraftAgainstCommercialPaperCardCommonQuery,$company,$overdraftAgainstCommercialPaperIds,$currencyName,$date,$year);
			
            $reports['cash_and_banks'][$currencyName] = $cashInSafeStatementAmountForCurrency + $currentAccountInBanks ;
            $reports['certificate_of_deposits'][$currencyName] =$totalCertificateOfDepositsForCurrentFinancialInstitutionAmount  ;
            $reports['time_deposits'][$currencyName] = $totalTimeDepositsForCurrentFinancialInstitutionAmount ;
			
            // $reports['credit_facilities_room'][$currencyName] = $totalCleanOverdraftRoom + $totalCleanOverdraftAgainstCommercialRoom ;

            $currentTotal = $reports['cash_and_banks'][$currencyName] + $reports['time_deposits'][$currencyName] + $reports['certificate_of_deposits'][$currencyName]  ;
            $reports['total'][$currencyName] = isset($reports['total'][$currencyName]) ? $reports['total'][$currencyName] + $currentTotal : $currentTotal ;
			
			
			#TODO: هنا احنا عاملينها لل كلين اوفر درافت بس .. عايزين نضف الباقي علشان يدخل في التوتال لما نعمله برضو
			$totalCard[$currencyName] = $this->sumForTotalCard($totalCard[$currencyName]??[],[$cleanOverdraftCardData[$currencyName]??0 , $fullySecuredOverdraftCardData[$currencyName]??0 , $overdraftAgainstCommercialPaperCardData[$currencyName]??0]);
		
		}
		
        return view('admin.dashboard.cash', [
			'mediumTermLoansArr'=>$mediumTermLoansArr,
            'company' => $company,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'reports' => $reports,
            'selectedCurrencies' => $selectedCurrencies,
			'allCurrencies'=>$allCurrencies,
            'selectedFinancialInstitutionsIds' => $selectedFinancialInstitutionBankIds,
			'totalCard'=>$totalCard,
			'details'=>$details,
			'date'=>$date,
			// cleanOverdraft
			
			'cleanOverdraftCardData' => $cleanOverdraftCardData,
			'totalRoomForEachCleanOverdraftId'=>$totalRoomForEachCleanOverdraftId,
			'cleanOverdraftAccountTypes'=>$cleanOverdraftAccountTypes,
			'allCleanOverdraftBanks'=>$allCleanOverdraftBanks,
			'hasCleanOverdraft'=>$hasCleanOverdraft ?? [],
			
			// fully secured
			'fullySecuredOverdraftCardData' => $fullySecuredOverdraftCardData,
			'totalRoomForEachFullySecuredOverdraftId'=>$totalRoomForEachFullySecuredOverdraftId,
			'fullySecuredOverdraftAccountTypes'=>$fullySecuredOverdraftAccountTypes,
			'allFullySecuredOverdraftBanks'=>$allFullySecuredOverdraftBanks,
			'hasFullySecuredOverdraft'=>$hasFullySecuredOverdraft ??[],
			
			
				// overdraftAgainstCommercialPaper
			
				'overdraftAgainstCommercialPaperCardData' => $overdraftAgainstCommercialPaperCardData,
				'totalRoomForEachOverdraftAgainstCommercialPaperId'=>$totalRoomForEachOverdraftAgainstCommercialPaperId,
				'overdraftAgainstCommercialPaperAccountTypes'=>$overdraftAgainstCommercialPaperAccountTypes,
				'allOverdraftAgainstCommercialPaperBanks'=>$allOverdraftAgainstCommercialPaperBanks,
				'hasOverdraftAgainstCommercialPaper'=>$hasOverdraftAgainstCommercialPaper ?? [],
				
			
        ]);
    }
	public function refreshBankMovementChart(Request $request,Company $company){
		$numberOfWeeks = 2 ;
		$currency = $request->get('currencyName');
		$accountNumber = $request->get('accountNumber');
		$companyId = $company->id ;
		$date = $request->get('date') ;
		$date = Carbon::make($date)->format('Y-m-d');
		$modelName = $request->get('modelName');
		$fullName = '\App\Models\\'.$modelName ;
		$financialInstitutionBankId = $request->get('bankId');
		$account = $fullName::findByAccountNumber($accountNumber,$companyId,$financialInstitutionBankId);
		$bankStatementName = $fullName::getBankStatementTableName() ;
		$foreignKeyInStatementTable = $fullName::getForeignKeyInStatementTable();
		$foreignKeyName = $fullName::generateForeignKeyFormModelName();
		$dateBeforeWeeks = Carbon::make($date)->subWeeks($numberOfWeeks)->format('Y-m-d');
		$model = new  $fullName ;
		$tableName = $model->getTable();
		$begin = new \DateTime($dateBeforeWeeks );
		$end   = new \DateTime( $date );
		$chartData = [];

		
		for($currentDateObject = $begin; $currentDateObject <= $end; $currentDateObject->modify('+1 day')){
			$currentDateAsString = $currentDateObject->format('Y-m-d') ;
			$totalsAtDate = DB::table($bankStatementName)
			->where($bankStatementName.'.company_id',$company->id)
			->where('date','=',$currentDateAsString)
			->where($foreignKeyName,$account->id)
			->orderByRaw('full_date desc')
			->join($tableName , $tableName.'.id' ,'=',$bankStatementName.'.'.$foreignKeyInStatementTable)
			->where('financial_institution_id',$financialInstitutionBankId)
			->where('currency',$currency)
			->selectRaw('sum(debit) as total_debit , sum(credit) as total_credit ')
			->get()->toArray();
			
			$lastEndBalanceAtCurrentDate = DB::table($bankStatementName)->where($bankStatementName.'.company_id',$company->id)
			->where('date','<=',$currentDateAsString)
			->where($foreignKeyName,$account->id)
			->orderByRaw('full_date desc')
			->join($tableName , $tableName.'.id' ,'=',$bankStatementName.'.'.$foreignKeyInStatementTable)
			->where('financial_institution_id',$financialInstitutionBankId)
			->where('currency',$currency)
			->first();
			$totalDebitAtCurrentDate = $totalsAtDate[0]->total_debit ?: 0;
			$totalCreditAtCurrentDate = $totalsAtDate[0]->total_credit ?: 0;
		
			
			$chartData[] = [
				'date'=>$currentDateAsString , 
				'debit'=>$totalDebitAtCurrentDate,
				'credit'=>$totalCreditAtCurrentDate,
				'end_balance'=>$lastEndBalanceAtCurrentDate ? $lastEndBalanceAtCurrentDate->end_balance : 0 
			];
			
		}
		return response()->json([
			'chart_date'=>$chartData
		]);

		
	}
	public function sumForTotalCard(array $oldArr  , array $newItems ):array{
		foreach($newItems as $index => $oldItems){
			foreach($oldItems as $key => $value){
				$oldArr[$key]   =  isset($oldArr[$key]) ? $oldArr[$key] + $value : $value ;
			}
		}
		return $oldArr;
	}
	
	public function formatFlowCashInOutChartData(array $totalCashInItems ,array $totalCashOutItems,array $dates ){
		$totalCashInItems = HArr::removeKeysFromArray($totalCashInItems,['total_of_total']);
		$totalCashOutItems = HArr::removeKeysFromArray($totalCashOutItems,['total_of_total']);
		// $dates2 = array_merge(array_keys($totalCashInItems),array_keys($totalCashOutItems));
		
		$formattedResult = [];
		foreach($dates as  $weekAndYear => $startAndEndDateArray){
				$endDate = $startAndEndDateArray['end_date'];
				$currentCashIn = $totalCashInItems[$weekAndYear] ?? 0 ;
				$currentCashOut = $totalCashOutItems[$weekAndYear] ?? 0 ;
				$formattedResult[] = ['date'=>$endDate,'cash_in'=>$currentCashIn , 'cash_out'=>$currentCashOut];
		}
		return $formattedResult;
	}
    public function viewForecastDashboard(Company $company, Request $request)
    {
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();
		$allCurrencies = getCurrenciesForSuppliersAndCustomers($company->id) ;
		// $financialInstitutionsThatHaveMediumTermLoans = FinancialInstitution::onlyCompany($company->id)->onlyHasMediumTermLoans()->get();
		$dashboardResult = [];
		
		$cashFlowReportResult = null ;
		$cashFlowReport = [];
		if($request->has('contract_id')){
			$report =(new ContractCashFlowReportController())->result($company,$request,true);
			$cashFlowReportResult = $report['result'];
			$dates = $report['dates'];
			$cashFlowReport['total_cash_in_out_flow']=$this->formatFlowCashInOutChartData($cashFlowReportResult['customers'][__('Total Cash Inflow')]['total'] ?? [],$cashFlowReportResult['cash_expenses'][__('Total Cash Outflow')]['total'] ?? [],$dates);
			$cashFlowReport['accumulated_net_cash']= formatAccumulatedNetCash($cashFlowReportResult['cash_expenses'][__('Net Cash (+/-)')]['total'] ?? [] ,$dates );
		}else{
			$report =(new CashFlowReportController())->result($company,$request,true);
			$cashFlowReportResult = $report['result'];
			$dates = $report['dates'];
			$cashFlowReport['total_cash_in_out_flow']=$this->formatFlowCashInOutChartData($cashFlowReportResult['customers'][__('Total Cash Inflow')]['total'] ?? [],$cashFlowReportResult['cash_expenses'][__('Total Cash Outflow')]['total'] ?? [],$dates);
			$cashFlowReport['accumulated_net_cash']= formatAccumulatedNetCash($cashFlowReportResult['cash_expenses'][__('Net Cash (+/-)')]['total'] ?? [] ,$dates );
		}
		
		$overdraftAccountTypes = AccountType::onlyOverdraftsAccounts()->get();
		$invoiceTypesModels = ['CustomerInvoice', 'SupplierInvoice'] ;
        $cashStartDate = $request->get('cash_start_date', now()->format('Y-m-d'));
        $cashEndDate = $request->get('cash_end_date', Carbon::make($cashStartDate)->addYear()->format('Y-m-d'));
		$withdrawalStartDate = now()->subMonths(WithdrawalsSettlementReportController::NUMBER_OF_INTERNAL_MONTHS)->format('Y-m-d');
		$withdrawalEndDate = $request->get('withdrawal_end_date',now()->format('Y-m-d'));
		
		$loanStartDate = $request->get('withdrawal_start_date',now()->format('Y-m-d'));
		$loanEndDate = now()->addMonths(WithdrawalsSettlementReportController::NUMBER_OF_INTERNAL_MONTHS)->format('Y-m-d');
		
		$agingDate = $request->get('aging_date',now()->format('Y-m-d'))  ;
        $selectedCurrencies = $request->get('currencies', $allCurrencies) ;

		
		$allFinancialInstitutionIds = $company->financialInstitutions->pluck('id')->toArray(); 
		foreach($selectedCurrencies as $currencyName)
		{
			foreach ($invoiceTypesModels as $modelType) {
				$clientNames = ('\App\Models\\' . $modelType)::getAllUniqueCustomerNames($company->id,$currencyName);
				/**
				 * * Customers Invoices Aging & Supplier Invoices Aging
				 */
				$invoiceAgingService = new InvoiceAgingService($company->id, $agingDate,$currencyName);
				$chequeAgingService = new ChequeAgingService($company->id, $agingDate,$currencyName);
		
				$agingsForInvoices = $invoiceAgingService->__execute($clientNames, $modelType) ;
				$agingsForInvoices = $invoiceAgingService->formatForDashboard($agingsForInvoices,$modelType);
				/**
				 * * Customers Cheques Aging & Supplier Cheques Aging
				 */
				$agingsForCheques = $chequeAgingService->__execute($clientNames, $modelType) ;
				$agingsForCheques = $chequeAgingService->formatForDashboard($agingsForCheques,$modelType);
	
				$dashboardResult['invoices_aging'][$modelType][$currencyName] = $agingsForInvoices ;
				
				$dashboardResult['cheques_aging'][$modelType][$currencyName] = $agingsForCheques ;
				
			}
		}
        return view('admin.dashboard.forecast', [
            'company' => $company,
			'dashboardResult'=>$dashboardResult,
			'invoiceTypesModels'=>$invoiceTypesModels,
			'cashStartDate'=>$cashStartDate,
			'cashEndDate'=>$cashEndDate,
			'withdrawalStartDate'=>$withdrawalStartDate,
			'withdrawalEndDate'=>$withdrawalEndDate,	
			'loanStartDate'=>$loanStartDate,
			'loanEndDate'=>$loanEndDate,
			'overdraftAccountTypes'=>$overdraftAccountTypes,
			'selectedCurrencies'=>$selectedCurrencies,
			'allFinancialInstitutionIds'=>$allFinancialInstitutionIds,
			'clientsWithContracts'=>$clientsWithContracts,
			'cashFlowReport'=>$cashFlowReport,
			
			'selectedReportInterval'=>$request->get('report_interval','weekly'),
			'selectedPartnerId'=>$request->get('partner_id'),
			'selectedContractId'=>$request->get('contract_id'),
			// 'financialInstitutionsThatHaveMediumTermLoans'=>$financialInstitutionsThatHaveMediumTermLoans
			
        ]);

        return view('admin.dashboard.forecast', ['company' => $company]);
    }

    public function showInvoiceReport(Company $company, Request $request, int $partnerId, string $currency, $modelType)
    {

        $fullClassName = ('\App\Models\\' . $modelType) ;

        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
        $moneyReceivedOrPaidText = (new $fullClassName())->getMoneyReceivedOrPaidText();
        $moneyReceivedOrPaidUrlName = (new $fullClassName())->getMoneyReceivedOrPaidUrlName();
        $invoices = ('App\Models\\' . $modelType)::where('company_id', $company->id)
        ->where($clientIdColumnName, $partnerId)
        ->where('currency', $currency)
		->orderByRaw('invoice_date asc , invoice_due_date desc , net_balance desc')
        ->get();
		
        $customer = Partner::find($partnerId);
        if (!count($invoices)) {
            return  redirect()->back()->with('fail', __('No Data Found'));
        }

        return view('admin.reports.invoice-report', [
            'invoices' => $invoices,
            'partnerName' => $customer->getName(),
            'partnerId' => $customer->getId(),
            'currency' => $currency,
            'isCollectedOrPaid' => 'is' . ucfirst($isCollectedOrPaid),
            'moneyReceivedOrPaidText' => $moneyReceivedOrPaidText,
            'moneyReceivedOrPaidUrlName' => $moneyReceivedOrPaidUrlName,
			'modelType'=>$modelType,
			'clientIdColumnName'=>$clientIdColumnName
        ]);
    }

	
	public function viewLGLCDashboard(Company $company, Request $request)
    {
			// start fully SecuredOverdraft
			$financialInstitutions = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
			$charts =  [];
			$tablesData = [];
			
			$lgTypes = LgTypes::getAll() ;
			$lgTypes = $request->ajax() && ! is_numeric($request->get('lgType')) ?  LgTypes::only((array) $request->get('lgType'))  : $lgTypes ; 
			
			$lcTypes = LcTypes::getAll() ;
			$lcTypes = $request->ajax() && ! is_numeric($request->get('lcType')) ?  LcTypes::only((array) $request->get('lcType'))  : $lcTypes ; 
			
			$typesForLgAndLc = [
				'lg'=>$lgTypes,
				'lc'=>$lcTypes
			];
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$financialInstitutionBankIds = $financialInstitutionBanks->pluck('id')->toArray();
		$selectedFinancialInstitutionBankIds = $request->ajax() && $request->get('financialInstitutionId') > 0 ? (array)$request->get('financialInstitutionId') : $financialInstitutionBankIds; 
	
		$currentDate = now()->format('Y-m-d') ;
        $date = $request->get('date');
		$date = $date ? HDate::formatDateFromDatePicker($date) : $currentDate;
		// $year = explode('-',$date)[0];
		$date = Carbon::make($date)->format('Y-m-d');
		$allCurrencies = getCurrenciesForSuppliersAndCustomers($company->id) ;
	
		$details = [];
		
		
		
        $selectedCurrencies = $request->get('currencies', $allCurrencies) ;
		$source = $request->get('lgSource');
        $reports = [];
		$canShowDashboardPerCurrency = [];
		 
		foreach(['lg'=>
		[
			'letter_of_facility_table_name'=>'letter_of_guarantee_facilities',
			'statement_table_name'=>'letter_of_guarantee_statements',
			
			'statement_table'=>'\App\Models\LetterOfGuaranteeStatement'
			] ,
			
			'lc'=>
		[
			'letter_of_facility_table_name'=>'letter_of_credit_facilities',
			'statement_table_name'=>'letter_of_credit_statements',
			'statement_table'=>'\App\Models\LetterOfCreditStatement'
			] 
			
			] as $currentLgOrLcType => $lgOrLcOptionsArr){
			$statementTableFullClassName = $lgOrLcOptionsArr['statement_table'];
			$letterOfFacilityTableName = $lgOrLcOptionsArr['letter_of_facility_table_name'];
			$currentStatementTableName = $lgOrLcOptionsArr['statement_table_name'];
			$lgOrLcTypes = $typesForLgAndLc[$currentLgOrLcType];
			
			foreach ($selectedCurrencies as $currencyName) {
					$canShowDashboardPerCurrency[$currentLgOrLcType][$currencyName]  = DB::table($currentStatementTableName)->where('company_id',$company->id)->where('currency',$currencyName)->exists();
				
				foreach($lgOrLcTypes as $currentLgType => $currentLgTitle){
					$statementTableFullClassName::getDashboardOutstandingPerTypeFormattedData($charts,$company,$currencyName , $date , $currentLgType,$source,$selectedFinancialInstitutionBankIds);
				}
				foreach ($selectedFinancialInstitutionBankIds as $financialInstitutionBankId) {
					
					$currentFinancialInstitution = FinancialInstitution::find($financialInstitutionBankId);
					$statementTableFullClassName::getDashboardOutstandingPerFinancialInstitutionFormattedData($charts,$company,$currencyName , $date ,$financialInstitutionBankId,$currentFinancialInstitution->getName(),$source,$lgOrLcTypes);
						
					$lastLetterOfGuaranteeOrCreditFacility = DB::table($letterOfFacilityTableName)
					->join('financial_institutions', $letterOfFacilityTableName.'.financial_institution_id', '=', 'financial_institutions.id')
					->where('financial_institutions.company_id', $company->id)
					->where('currency', $currencyName)
					->where('contract_start_date', '<=', $date)
					->where($letterOfFacilityTableName.'.financial_institution_id', '=', $financialInstitutionBankId)
					->orderBy('contract_start_date', 'desc')
					->limit(1)
					->first();
						foreach($lgOrLcTypes as $currentLgType => $currentLgTitle){
							$statementTableFullClassName::getDashboardOutstandingTableFormattedData($tablesData,$company,$currencyName , $date ,$financialInstitutionBankId,$currentLgType,$currentFinancialInstitution->getName(),$lastLetterOfGuaranteeOrCreditFacility,$source);
						}
			
						$details[$currencyName][$currentLgOrLcType][] = [
							'limit'=>$currentLimit = $lastLetterOfGuaranteeOrCreditFacility ? $lastLetterOfGuaranteeOrCreditFacility->limit : 0 ,
							'outstanding_balance'=> $currentOutstanding = $statementTableFullClassName::getTotalOutstandingBalanceForAllTypes($company->id,$financialInstitutionBankId,$currencyName)  , 
							'room'=> $currentRoom = $currentLimit - $currentOutstanding ,
							'cash_cover'=> $currentCashCover = $statementTableFullClassName::getTotalCashCoverForAllTypes($company->id,$financialInstitutionBankId,$currencyName)  , 
							'financial_institution_name'=>$currentFinancialInstitution->getName()
						] ;
					$total[$currentLgOrLcType][$currencyName]['limit'] = isset($total[$currentLgOrLcType][$currencyName]['limit']) ? $total[$currentLgOrLcType][$currencyName]['limit'] + $currentLimit  : $currentLimit ;
					$total[$currentLgOrLcType][$currencyName]['outstanding_balance'] = isset($total[$currentLgOrLcType][$currencyName]['outstanding_balance']) ? $total[$currentLgOrLcType][$currencyName]['outstanding_balance'] + $currentOutstanding  : $currentOutstanding ;
					$total[$currentLgOrLcType][$currencyName]['room'] = isset($total[$currentLgOrLcType][$currencyName]['room']) ? $total[$currentLgOrLcType][$currencyName]['room'] + $currentRoom  : $currentRoom ;
					$total[$currentLgOrLcType][$currencyName]['cash_cover'] = isset($total[$currentLgOrLcType][$currencyName]['cash_cover']) ? $total[$currentLgOrLcType][$currencyName]['cash_cover'] + $currentCashCover  : $currentCashCover ;
		
	
				}
				$reports[$currentLgOrLcType][$currencyName]['limit'] = $total[$currentLgOrLcType][$currencyName]['limit'] ?? 0 ;
				$reports[$currentLgOrLcType][$currencyName]['outstanding_balance'] = $total[$currentLgOrLcType][$currencyName]['outstanding_balance'] ?? 0 ;
				$reports[$currentLgOrLcType][$currencyName]['room'] = $total[$currentLgOrLcType][$currencyName]['room'] ?? 0 ;
				$reports[$currentLgOrLcType][$currencyName]['cash_cover'] = $total[$currentLgOrLcType][$currencyName]['cash_cover'] ?? 0 ;
			}
			
			
		}
        
		
		if($request->ajax()){
			
			return response()->json([
				'tablesData'=>$tablesData ,
				'charts'=>$charts
			]);
		}
	
        return view('admin.reports.lglc-report', [
            'company' => $company,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'reports' => $reports,
            'selectedCurrencies' => $selectedCurrencies,
			'allCurrencies'=>$allCurrencies,
            'selectedFinancialInstitutionsIds' => $selectedFinancialInstitutionBankIds,
			'details'=>$details,
			'charts'=>$charts,
			'lgTypes'=>LgTypes::getAll(),
			'lcTypes'=>LcTypes::getAll(),
			'lgSources'=>LetterOfGuaranteeIssuance::lgSources(),
			'lcSources'=>LetterOfCreditIssuance::lcSources(),
			'tablesData'=>$tablesData,
			'financialInstitutions'=>$financialInstitutions,
			'canShowDashboardPerCurrency'=>$canShowDashboardPerCurrency
			
        ]);
    }


    public function showCustomerInvoiceStatementReport(Company $company, Request $request, int $partnerId, string $currency, string $modelType , string $startDate = null , string $endDate = null , bool $returnResult = false)
    {
		$showAllPartner = $request->boolean('all_partners');
		$partnerId = $request->has('partner_id') ? $request->get('partner_id') : $partnerId;
        $fullClassName = ('\App\Models\\' . $modelType) ;
		$isCustomer = $modelType == 'CustomerInvoice' ? 1 : 0;
		$isSupplier = $modelType == 'CustomerInvoice' ? 0 : 1;
		
		$partners = Partner::when($partnerId && !$showAllPartner ,function(Builder $builder) use ($partnerId,$isSupplier,$isCustomer){
			$builder->whereIn('id',(array) $partnerId )->where('is_customer',$isCustomer)->where('is_supplier',$isSupplier);
		})->whereHas($modelType,function(Builder $builder) use($currency){
			$builder->where('currency',$currency);
		})
		->where('company_id',$company->id)
		->pluck('name','id')->toArray();

        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $customerStatementText = (new $fullClassName())->getCustomerOrSupplierStatementText();
        $startDate = $startDate ?: $request->get('start_date', now()->subMonths(4)->format('Y-m-d'));
        $endDate = $endDate?: $request->get('end_date', now()->format('Y-m-d'));
        $invoices = ('\App\Models\\' . $modelType)::where('company_id', $company->id)
        ->where('currency', $currency)
        ->whereBetween('invoice_date', [$startDate, $endDate])
        ->where($clientIdColumnName, '=', $partnerId)->get();
        $partner = Partner::find($partnerId);
		if(!$partner){
			return view('admin.reports.customer-statement-report', [
				'invoicesWithItsReceivedMoney' => [],
				'partnerName' => null,
				'partnerId' => $partnerId,
				'currency' => $currency,
				'startDate' => $startDate,
				'endDate' => $endDate,
				'customerStatementText' => $customerStatementText,
				'partners'=>$partners,
				'showAllPartner'=>$showAllPartner
			]);
		}
        $partnerName = $partner->getName() ;
        $invoicesWithItsReceivedMoney = ('App\Models\\' . $modelType)::formatForStatementReport($invoices, $partnerName, $startDate, $endDate, $currency);

		if($returnResult){
			if(count($invoicesWithItsReceivedMoney) < 1){
				return [];
			}
			return $invoicesWithItsReceivedMoney ;
		}
        if (count($invoicesWithItsReceivedMoney) < 1) {
            return  redirect()->back()->with('fail', __('No Data Found'));
        }
        return view('admin.reports.customer-statement-report', [
            'invoicesWithItsReceivedMoney' => $invoicesWithItsReceivedMoney,
            'partnerName' => $partnerName,
            'partnerId' => $partnerId,
            'currency' => $currency,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerStatementText' => $customerStatementText,
			'partners'=>$partners,
			'showAllPartner'=>$showAllPartner
        ]);
    }
	protected function getKeysFromStdClass(?\Illuminate\Support\Collection $stdClass , array $keys,array $additionalData = []):array 
{
	$result = [];
	foreach($stdClass as $index => $stdObject)
	{
		$stdArray = (array) $stdObject;
		$result[] = array_merge( Arr::only($stdArray , $keys) , $additionalData );
	}
	return $result ;
	
}
	
}
