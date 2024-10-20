<?php

namespace App\Http\Controllers;

use App\Helpers\HArr;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitutionAccount;
use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Models\SettlementAllocation;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractCashFlowReportController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();
        return view('reports.contract_cash_flow_form', compact('company','clientsWithContracts'));
    }
	public function result(Company $company , Request $request , bool $returnResultAsArray = false ,  ){
		
		$formStartDate =$request->get('start_date',$request->get('cash_start_date'));
		 
		$formEndDate =$request->get('end_date',$request->get('cash_end_date'));
		
		$reportInterval =  $request->get('report_interval','weekly');
		$contractId = $request->get('contract_id')	 ;
		$finalResult = [];
		/////////////////////
		$contract = Contract::find($contractId);
		
		
		/**
		 * @var Contract $contract 
		 */
		$contractCode = $contract ? $contract->getCode() : null ;
		if(is_null($contractCode)){
			return redirect()->back()->with('fail',__('Please Select Contract'));
		}
		$customer = $contract ? $contract->client : null ;
		$customerId = $customer ? $customer->getId() : null ;
		$result['customers']=[
			'Checks Collected'=>[],
			'Incoming Transfers'=>[],
			'Bank Deposits'=> [],
			'Cash Collections'=> [],
			'Cheques Under Collection'=>[],
			'Cheques In Safe'=>[],
			'Customers Invoices'=>[],
			'Customers Past Due Invoices'=>[],
			__('Total Cash Inflow')=>[]
		];
		$pastDueCustomerInvoicesPerCurrency = [];
		$customerDueInvoicesPerCurrency = [];
		$noRowHeaders =  $reportInterval == 'weekly' ? 3 : 1 ;
		$months = generateDatesBetweenTwoDates(Carbon::make($formStartDate),Carbon::make($formEndDate)); 
		$days = generateDatesBetweenTwoDates(Carbon::make($formStartDate),Carbon::make($formEndDate),'addDay'); 
		$startDate = $request->get('start_date',$request->get('cash_start_date'));
		$year = explode('-',$startDate)[0];
		$endDate  = $request->get('end_date',$request->get('cash_end_date'));
		$datesWithWeeks = [];
		if($reportInterval == 'weekly'){
			$datesWithWeeks = 	getWeekNumberBetweenDates($year , Carbon::make($endDate)) ;
		}
		elseif($reportInterval == 'monthly'){
			$datesWithWeeks = 	getMonthNumberBetweenDates($year , Carbon::make($endDate)) ;
		}
		elseif($reportInterval == 'daily'){
			$datesWithWeeks = 	getDayNumberBetweenDates($year , Carbon::make($endDate)) ;
		}
		$weeks  = $this->mergeYearWithWeek($datesWithWeeks ,Carbon::make($startDate) );
	
		$firstIndex = array_key_first($weeks);
		$lastIndex = array_key_last($weeks);
		$dates = [];
		$rangedWeeks = [];
		$totalCashInFlowArray = [];
		$totalCashOutFlowArray = [];

		$allCurrencies = FinancialInstitutionAccount::getAllCurrentAccountCurrenciesForCompany($company->id) ;
		foreach($allCurrencies as $currencyName){
			$result = [];
			
			
			foreach($weeks as $currentWeekYear=>$week){
				$currentYear = explode('-',$currentWeekYear)[1];
				if($currentWeekYear == $firstIndex){
					$startDate = $startDate ;
					$endDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['end_date'];
				}
				elseif($currentWeekYear == $lastIndex){
					$startDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['start_date'];
					$endDate = $request->get('end_date',$request->get('cash_end_date'));  
				}
				else
				{
					$rangedWeeks = getMinDateOfWeek($datesWithWeeks,$week,$currentYear);
					$startDate = $rangedWeeks['start_date'];
					$endDate = $rangedWeeks['end_date'];
				}
				
					 CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result,$totalCashInFlowArray ,MoneyReceived::CHEQUE,'expected_collection_date',$startDate , $endDate,$contractCode,$currentWeekYear,Cheque::UNDER_COLLECTION,$currencyName,$company->id) ;
				// for customers 
					$pastDueCustomerInvoices = $this->getPastDueCustomerInvoices('CustomerInvoice',$currencyName,$company->id,$request->get('start_date',$request->get('cash_start_date')),$contractCode);
					$excludeIds = $pastDueCustomerInvoices->where('net_balance_until_date','<=',0)->pluck('id')->toArray() ;
					$pastDueCustomerInvoicesPerCurrency[$currencyName] = $pastDueCustomerInvoices;
					$customerDueInvoices=DB::table('weekly_cashflow_custom_due_invoices')->where('company_id',$company->id)
					->where('invoice_type','CustomerInvoice')
					->whereNotIn('invoice_id',$excludeIds)
					->groupBy('week_start_date')->selectRaw('week_start_date,sum(amount) as amount')->get();
					$customerDueInvoicesPerCurrency[$currencyName] = $customerDueInvoices ;
					CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result ,$totalCashInFlowArray,MoneyReceived::INCOMING_TRANSFER,'receiving_date',$startDate , $endDate,$contractCode,$currentWeekYear,null,$currencyName);
				
					 CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result,$totalCashInFlowArray,MoneyReceived::CHEQUE,'actual_collection_date',$startDate , $endDate,$contractCode,$currentWeekYear,Cheque::COLLECTED,$currencyName,$company->id);
					 CustomerInvoice::getCustomerInvoicesUnderCollectionAtDatesForContracts($result,$totalCashInFlowArray,$company->id,$startDate , $endDate,$currencyName,$contractCode,$currentWeekYear);
					 CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result ,$totalCashInFlowArray, MoneyReceived::CASH_IN_SAFE,'receiving_date',$startDate , $endDate,$contractCode,$currentWeekYear,$currencyName,$company->id);
					 CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result ,$totalCashInFlowArray, MoneyReceived::CASH_IN_BANK,'receiving_date',$startDate , $endDate,$contractCode,$currentWeekYear,$currencyName,$company->id);
				$result['customers'][__('Customers Past Due Invoices')] = [];
				 CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result,$totalCashInFlowArray,MoneyReceived::CHEQUE,'due_date',$startDate , $endDate,$contractCode,$currentWeekYear,Cheque::IN_SAFE,$currencyName,$company->id);
		
					SettlementAllocation::getSettlementAllocationPerContractAndMoneyType($result , $totalCashOutFlowArray  , MoneyPayment::OUTGOING_TRANSFER,'delivery_date',$contractId,$customerId,$startDate,$endDate,$currentWeekYear,$currencyName);
					SettlementAllocation::getSettlementAllocationPerContractAndMoneyType($result , $totalCashOutFlowArray  , MoneyPayment::CASH_PAYMENT,'delivery_date',$contractId,$customerId,$startDate,$endDate,$currentWeekYear,$currencyName);
					SettlementAllocation::getSettlementAllocationPerContractAndMoneyType($result , $totalCashOutFlowArray  , MoneyPayment::PAYABLE_CHEQUE,'actual_payment_date',$contractId,$customerId,$startDate,$endDate,$currentWeekYear,$currencyName,PayableCheque::PAID);
					SettlementAllocation::getSettlementAllocationPerContractAndMoneyType($result , $totalCashOutFlowArray , MoneyPayment::PAYABLE_CHEQUE,'due_date',$contractId,$customerId,$startDate,$endDate,$currentWeekYear,$currencyName,PayableCheque::PENDING);
					SettlementAllocation::getSettlementAllocationPerContractAndLetterOfCreditIssuance($result , $totalCashOutFlowArray ,'due_date',$contractId,$customerId,$startDate,$endDate,$currentWeekYear,$currencyName,PayableCheque::PENDING);
					
					$contract->getCashExpensePerCategoryName($result,$totalCashOutFlowArray,MoneyPayment::OUTGOING_TRANSFER,'payment_date',$startDate,$endDate,$currentWeekYear,$currencyName);
					$contract->getCashExpensePerCategoryName($result,$totalCashOutFlowArray,MoneyPayment::CASH_PAYMENT,'payment_date',$startDate,$endDate,$currentWeekYear,$currencyName);
					$contract->getCashExpensePerCategoryName($result,$totalCashOutFlowArray,MoneyPayment::PAYABLE_CHEQUE,'actual_payment_date',$startDate,$endDate,$currentWeekYear,$currencyName,PayableCheque::PAID);
					$contract->getCashExpensePerCategoryName($result,$totalCashOutFlowArray,MoneyPayment::PAYABLE_CHEQUE,'due_date',$startDate,$endDate,$currentWeekYear,$currencyName,PayableCheque::PENDING);
					
					$dates[$currentWeekYear] = [
						'start_date' => $startDate,
						'end_date'=>$endDate 
					];
			}
			$totalCashInFlowArray = $this->mergeTotal($totalCashInFlowArray,$customerDueInvoices);
			$result['customers'][__('Total Cash Inflow')]['total'] = $totalCashInFlowArray ;
			$result['customers'][__('Total Cash Inflow')]['total']['total_of_total'] = array_sum($totalCashInFlowArray);
			$result['cash_expenses'][__('Total Cash Outflow')]['total'] = $totalCashOutFlowArray;
			$result['cash_expenses'][__('Total Cash Outflow')]['total']['total_of_total'] = array_sum($totalCashOutFlowArray);
			$netCash = HArr::subtractAtDates([$totalCashInFlowArray,$totalCashOutFlowArray] , array_merge(array_keys($totalCashInFlowArray),array_keys($totalCashOutFlowArray))) ;
			$result['cash_expenses'][__('Net Cash (+/-)')]['total'] = $netCash;
			$result['cash_expenses'][__('Net Cash (+/-)')]['total']['total_of_total'] = array_sum($netCash) ;
			$result['cash_expenses'][__('Accumulated Net Cash (+/-)')]['total'] = $this->formatAccumulatedNetCash($netCash,$weeks);
			$finalResult[$currencyName] = $result;
		}
		if($returnResultAsArray){
			return [
				'result'=>$result , 
				'dates'=>$dates,
			] ;
		}

		return view('admin.reports.contract-cash-flow-report',[
			'weeks'=>$weeks,
			// 'result'=>$result,
			'dates'=>$dates,
			'pastDueCustomerInvoices'=>$pastDueCustomerInvoicesPerCurrency,
			'customerDueInvoices'=>$customerDueInvoicesPerCurrency,
			'months'=>$months ,
			'days'=>$days,
			'reportInterval'=>$reportInterval,
			'noRowHeaders'=>$noRowHeaders,
			'finalResult'=>$finalResult,
			'allCurrencies'=>$allCurrencies
		]);
	}
	public function formatAccumulatedNetCash(array $netCashes,array $weeks)
	{
		$currentAccumulated = 0 ;
		$result = [];

		foreach($weeks as $week => $weekNumber){
			$currentAccumulated +=  $netCashes[$week] ?? 0;
			$result[$week] = $currentAccumulated ;
		}
		return $result ;
	}
	public function mergeTotal(array $totals , $collectionOfItems):array 
	{
		foreach($collectionOfItems as $itemStdClass){
			$week = $itemStdClass->week_start_date;
			$currentAmount = $itemStdClass->amount;
			$year = explode('-',$week)[0];
			$month = explode('-',$week)[1];
			$totals[$month.'-'.$year] = isset($totals[$month.'-'.$year]) ? $totals[$month.'-'.$year] + $currentAmount : $currentAmount;
		}
		return $totals;
	}
	protected function mergeYearWithWeek(array $weeks , Carbon $startDate ):array{
		$newWeeks = [];
		if(!count($weeks)){
			return [];
		}
		foreach($weeks as $date => $weekNumber){
			$currentDate =Carbon::make($date);
				$year = $currentDate->year ;
				if($currentDate->greaterThanOrEqualTo($startDate)){
					$newWeeks[$weekNumber.'-'.$year] = $weekNumber; 
				}
		}
		return $newWeeks;
		
	}
	public function getPastDueCustomerInvoices(string $invoiceType,string $currency , int $companyId , string $startDate,string $contractCode ){
		$fullClassName = '\App\Models\\'.$invoiceType;
		$items  = $fullClassName::where('company_id',$companyId)
		->where('contract_code',$contractCode)
		->where('net_balance','>',0)
		->whereIn('invoice_status',['past_due','partially_collected_and_past_due'])
		->where('currency',$currency)->where('invoice_due_date','<',$startDate)->get() ;
		foreach($items as $item){
			$item->net_balance_until_date = $item->getNetBalanceUntil($startDate);
		}
		return $items;
	}
}
