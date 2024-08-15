<?php

namespace App\Http\Controllers;
use App\Helpers\HDate;
use App\Models\AccountType;
use App\Models\ActiveJob;
use App\Models\CashInSafeStatement;
use App\Models\CertificatesOfDeposit;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\FullySecuredOverdraft;
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
		$allCurrencies = getCurrenciesForSuppliersAndCustomers() ;
	
		$details = [];
		
		
		
        $selectedCurrencies = $request->get('currencies', $allCurrencies) ;
        $reports = [];
		
		$totalCard = [];
        foreach ($selectedCurrencies as $currencyName) {
			$currentAccountInBanks = 0 ;
			$totalCertificateOfDepositsForCurrentFinancialInstitutionAmount = 0 ;
            $totalTimeDepositsForCurrentFinancialInstitutionAmount = 0 ;
			
			$cashInSafeStatementAmountForCurrency = 0 ;
			$cashInSafeStatementAmountForCurrency = CashInSafeStatement::
			where('date', '<=', $date)
			->where('company_id', $company->id)
			->where('currency', $currencyName)
			->orderByRaw('full_date desc')->limit(1)->first();
			$details[$currencyName]['cash_in_safe'][] = [
				'amount'=>$cashInSafeStatementAmountForCurrency ? $cashInSafeStatementAmountForCurrency->end_balance : 0 ,
				'branch_name'=>$cashInSafeStatementAmountForCurrency && $cashInSafeStatementAmountForCurrency->branch ? $cashInSafeStatementAmountForCurrency->branch->getName() : __('N/A'),
			] ;
			$cashInSafeStatementAmountForCurrency = $cashInSafeStatementAmountForCurrency ? $cashInSafeStatementAmountForCurrency->end_balance : 0;
			
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


                $currentAccountEndBalanceForCurrency = DB::table('current_account_bank_statements')
                ->join('financial_institution_accounts', 'financial_institution_account_id', '=', 'financial_institution_accounts.id')
                ->where('financial_institution_accounts.company_id', $company->id)
                ->where('currency', $currencyName)
                ->where('date', '<=', $date)
                ->where('financial_institution_accounts.financial_institution_id', '=', $financialInstitutionBankId)
                ->orderBy('current_account_bank_statements.full_date', 'desc')
                ->limit(1)
                ->first();
				
		
					$details[$currencyName]['current_account'][] = [
						'amount'=>$currentAccountEndBalanceForCurrency ? $currentAccountEndBalanceForCurrency->end_balance : 0 ,
						'account_number'=>$currentAccountEndBalanceForCurrency ? $currentAccountEndBalanceForCurrency->account_number : 0,
						'financial_institution_name'=>$currentFinancialInstitution->getName()
					] ;
					
				
                $currentAccountEndBalanceForCurrency = $currentAccountEndBalanceForCurrency ? $currentAccountEndBalanceForCurrency->end_balance : 0;

                $currentAccountInBanks += $currentAccountEndBalanceForCurrency ;

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
				
				->selectRaw(' "'. $financialInstitutionName .'" as financial_institution_name , certificates_of_deposits.account_number as account_number,certificates_of_deposits.amount as amount, case when fully_secured_overdrafts.cd_or_td_account_type_id = '.$cdAccountTypeId .' then "'.  __('Overdraft') 
				.'" when letter_of_guarantee_issuances.cd_or_td_account_type_id = '.$cdAccountTypeId .' then "' .  __('LG') 
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
				->selectRaw(' "'. $financialInstitutionName .'" as financial_institution_name , time_of_deposits.account_number as account_number,time_of_deposits.amount as amount, case when fully_secured_overdrafts.cd_or_td_account_type_id = '.$tdAccountTypeId .' then "'.  __('Overdraft') 
				.'" when letter_of_guarantee_issuances.cd_or_td_account_type_id = '.$tdAccountTypeId .' then "' .  __('LG') 
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
            'company' => $company,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'reports' => $reports,
            'selectedCurrencies' => $selectedCurrencies,
			'allCurrencies'=>$allCurrencies,
            'selectedFinancialInstitutionsIds' => $selectedFinancialInstitutionBankIds,
			'totalCard'=>$totalCard,
			'details'=>$details,
			
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
		// dd($newItems,'old',$oldArr);
		foreach($newItems as $index => $oldItems){
			foreach($oldItems as $key => $value){
				// dd($value);
				$oldArr[$key]   =  isset($oldArr[$key]) ? $oldArr[$key] + $value : $value ;
			}
		}
		// dd($oldArr);
		return $oldArr;
	}

    public function viewForecastDashboard(Company $company, Request $request)
    {
		$allCurrencies = getCurrenciesForSuppliersAndCustomers() ;
		$details = [];
		$dashboardResult = [];
		$overdraftAccountTypes = AccountType::onlyOverdraftsAccounts()->get();
		$invoiceTypesModels = ['CustomerInvoice', 'SupplierInvoice'] ;
        $startDate = $request->get('start_date', now()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::make($startDate)->addYear()->format('Y-m-d'));
		$aginDate = $startDate ;
        $selectedCurrencies = $request->get('currencies', $allCurrencies) ;
		$invoiceAgingService = new InvoiceAgingService($company->id, $aginDate);
		$chequeAgingService = new ChequeAgingService($company->id, $aginDate);
		$allFinancialInstitutionIds = $company->financialInstitutions->pluck('id')->toArray(); 
		foreach($selectedCurrencies as $currencyName)
		{
			foreach ($invoiceTypesModels as $modelType) {
				$clientNames = ('\App\Models\\' . $modelType)::getAllUniqueCustomerNames($company->id,$currencyName);
	
				/**
				 * * Customers Invoices Aging & Supplier Invoices Aging
				 */
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
			'startDate'=>$startDate,
			'endDate'=>$endDate,
			'overdraftAccountTypes'=>$overdraftAccountTypes,
			'selectedCurrencies'=>$selectedCurrencies,
			'allFinancialInstitutionIds'=>$allFinancialInstitutionIds
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
		return view('admin.reports.lglc-report');

        // $fullClassName = ('\App\Models\\' . $modelType) ;

        // $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        // $isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
        // $moneyReceivedOrPaidText = (new $fullClassName())->getMoneyReceivedOrPaidText();
        // $moneyReceivedOrPaidUrlName = (new $fullClassName())->getMoneyReceivedOrPaidUrlName();
        // $invoices = ('App\Models\\' . $modelType)::where('company_id', $company->id)
        // ->where($clientIdColumnName, $partnerId)
        // ->where('currency', $currency)
        // ->get();
        // $customer = Partner::find($partnerId);
        // if (!count($invoices)) {
        //     return  redirect()->back()->with('fail', __('No Data Found'));
        // }

        // return view('admin.reports.invoice-report', [
        //     'invoices' => $invoices,
        //     'partnerName' => $customer->getName(),
        //     'partnerId' => $customer->getId(),
        //     'currency' => $currency,
        //     'isCollectedOrPaid' => 'is' . ucfirst($isCollectedOrPaid),
        //     'moneyReceivedOrPaidText' => $moneyReceivedOrPaidText,
        //     'moneyReceivedOrPaidUrlName' => $moneyReceivedOrPaidUrlName,
		// 	'modelType'=>$modelType
        // ]);
    }

    public function showCustomerInvoiceStatementReport(Company $company, Request $request, int $partnerId, string $currency, string $modelType)
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
        $isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
        $moneyReceivedOrPaidText = (new $fullClassName())->getMoneyReceivedOrPaidText();
        $moneyReceivedOrPaidUrlName = (new $fullClassName())->getMoneyReceivedOrPaidUrlName();
        $customerStatementText = (new $fullClassName())->getCustomerOrSupplierStatementText();
        $startDate = $request->get('start_date', now()->subMonths(4)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
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
