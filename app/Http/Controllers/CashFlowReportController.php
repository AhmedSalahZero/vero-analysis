<?php

namespace App\Http\Controllers;

use App\Helpers\HArr;
use App\Models\CashExpense;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\PayableCheque;
use App\Models\SupplierInvoice;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashFlowReportController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
        return view('reports.cash_flow_form', compact('company'));
    }
	public function result(Company $company , Request $request, bool $returnResultAsArray = false ){
		$defaultStartDate = $request->get('cash_start_date',now()->format('Y-m-d'));
		$defaultEndDate = $request->get('cash_end_date',now()->addMonth()->format('Y-m-d'));
		$formStartDate =$request->get('start_date',$defaultStartDate); 
		$formEndDate =$request->get('end_date',$defaultEndDate);
		$reportInterval =  $request->get('report_interval','weekly');
		// $reportInterval = 'daily';
		$result = [];
		// $cashExpenseCategoryNamesArr = [];
		
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
		
		$noRowHeaders =  $reportInterval == 'weekly' ? 3 : 1 ;
		
		
		$months = generateDatesBetweenTwoDates(Carbon::make($formStartDate),Carbon::make($formEndDate)); 
		$days = generateDatesBetweenTwoDates(Carbon::make($formStartDate),Carbon::make($formEndDate),'addDay'); 
		$startDate = $request->get('start_date',$defaultStartDate);
		$currency = $request->get('currency',$company->getMainFunctionalCurrency());
		$year = explode('-',$startDate)[0];
		$endDate  = $request->get('end_date',$defaultEndDate);
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
		foreach($weeks as $currentWeekYear=>$week){
			
			$currentYear = explode('-',$currentWeekYear)[1];
			if($currentWeekYear == $firstIndex){
				$startDate = $startDate ;
				$endDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['end_date'];
			}
			elseif($currentWeekYear == $lastIndex){
				$startDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['start_date'];
				$endDate = $request->get('end_date',$defaultEndDate);  
			}
			else
			{
				$rangedWeeks = getMinDateOfWeek($datesWithWeeks,$week,$currentYear);
				$startDate = $rangedWeeks['start_date'];
				$endDate = $rangedWeeks['end_date'];
			}
			CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result,$totalCashInFlowArray ,MoneyReceived::CHEQUE,'expected_collection_date',$startDate , $endDate,null,$currentWeekYear,Cheque::UNDER_COLLECTION,$currency,$company->id) ;
			CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result,$totalCashInFlowArray,MoneyReceived::CHEQUE,'actual_collection_date',$startDate , $endDate,null,$currentWeekYear,Cheque::COLLECTED,$currency,$company->id);
			CustomerInvoice::getCustomerInvoicesUnderCollectionAtDatesForContracts($result,$totalCashInFlowArray,$company->id,$startDate , $endDate,$currency,null,$currentWeekYear);
			CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result ,$totalCashInFlowArray,MoneyReceived::INCOMING_TRANSFER,'receiving_date',$startDate , $endDate,null,$currentWeekYear,null,$currency,$company->id);
			CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result ,$totalCashInFlowArray, MoneyReceived::CASH_IN_BANK,'receiving_date',$startDate , $endDate,null,$currentWeekYear,null,$currency,$company->id);
			CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result ,$totalCashInFlowArray, MoneyReceived::CASH_IN_SAFE,'receiving_date',$startDate , $endDate,null,$currentWeekYear,null,$currency,$company->id);
			

			$result['customers']['Customers Past Due Invoices'] = [];
			CustomerInvoice::getSettlementAmountUnderDateForSpecificType($result,$totalCashInFlowArray,MoneyReceived::CHEQUE,'due_date',$startDate , $endDate,null,$currentWeekYear,Cheque::IN_SAFE,$currency,$company->id);
			
			 MoneyPayment::getCashOutForMoneyTypeAtDates($result,$totalCashOutFlowArray,MoneyPayment::OUTGOING_TRANSFER,'delivery_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear);
			 MoneyPayment::getCashOutForMoneyTypeAtDates($result,$totalCashOutFlowArray,MoneyPayment::CASH_PAYMENT,'delivery_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear);
			 MoneyPayment::getCashOutForMoneyTypeAtDates($result,$totalCashOutFlowArray,MoneyPayment::PAYABLE_CHEQUE,'actual_payment_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear,PayableCheque::PAID);
			 MoneyPayment::getCashOutForMoneyTypeAtDates($result,$totalCashOutFlowArray,MoneyPayment::PAYABLE_CHEQUE,'due_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear,PayableCheque::PENDING);

			 SupplierInvoice::getSupplierInvoicesUnderCollectionAtDates($result,$totalCashOutFlowArray,$company->id,$startDate,$endDate,$currency,$currentWeekYear);
			CashExpense::getCashOutForExpenseCategoriesAtDates($result,$totalCashOutFlowArray,CashExpense::OUTGOING_TRANSFER,'payment_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear,null);
			CashExpense::getCashOutForExpenseCategoriesAtDates($result,$totalCashOutFlowArray,CashExpense::CASH_PAYMENT,'payment_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear,null);
			CashExpense::getCashOutForExpenseCategoriesAtDates($result,$totalCashOutFlowArray,CashExpense::PAYABLE_CHEQUE,'actual_payment_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear,PayableCheque::PAID);
			CashExpense::getCashOutForExpenseCategoriesAtDates($result,$totalCashOutFlowArray,CashExpense::PAYABLE_CHEQUE,'due_date',$currency,$company->id,$startDate,$endDate,$currentWeekYear,PayableCheque::PENDING);
			
			$result['suppliers']['Suppliers Past Due Invoices'] = [];
		
			$dates[$currentWeekYear] = [
				'start_date' => $startDate,
				'end_date'=>$endDate 
			];
		}
		
		
		
		
		// for customers 
		$pastDueCustomerInvoices = $this->getPastDueCustomerInvoices('CustomerInvoice',$currency,$company->id,$request->get('start_date',$defaultStartDate));
		$excludeIds = $pastDueCustomerInvoices->where('net_balance_until_date','<=',0)->pluck('id')->toArray() ;
		$customerDueInvoices=DB::table('weekly_cashflow_custom_due_invoices')->where('company_id',$company->id)
		->where('invoice_type','CustomerInvoice')
		->whereNotIn('invoice_id',$excludeIds)
		->groupBy('week_start_date')->selectRaw('week_start_date,sum(amount) as amount')->get();
		
		
		
		// for suppliers 
		$pastDueSupplierInvoices = $this->getPastDueCustomerInvoices('SupplierInvoice',$currency,$company->id,$request->get('start_date',$defaultStartDate));
		$excludeIds = $pastDueSupplierInvoices->where('net_balance_until_date','<=',0)->pluck('id')->toArray() ;
		$supplierDueInvoices=DB::table('weekly_cashflow_custom_due_invoices')->where('company_id',$company->id)
		->where('invoice_type','SupplierInvoice')
		->whereNotIn('invoice_id',$excludeIds)
		->groupBy('week_start_date')->selectRaw('week_start_date,sum(amount) as amount')->get();
	
		
		
		$totalCashInFlowArray = $this->mergeTotal($totalCashInFlowArray,$customerDueInvoices);
		$totalCashOutFlowArray = $this->mergeTotal($totalCashOutFlowArray,$supplierDueInvoices);
		
		$result['customers'][__('Total Cash Inflow')]['total'] = $totalCashInFlowArray ;
		$result['customers'][__('Total Cash Inflow')]['total']['total_of_total'] = array_sum($totalCashInFlowArray);
		$result['cash_expenses'][__('Total Cash Outflow')]['total'] = $totalCashOutFlowArray;
		$result['cash_expenses'][__('Total Cash Outflow')]['total']['total_of_total'] = array_sum($totalCashOutFlowArray);
		$netCash = HArr::subtractAtDates([$totalCashInFlowArray,$totalCashOutFlowArray] , array_merge(array_keys($totalCashInFlowArray),array_keys($totalCashOutFlowArray))) ;
		$result['cash_expenses'][__('Net Cash (+/-)')]['total'] = $netCash;
		$result['cash_expenses'][__('Net Cash (+/-)')]['total']['total_of_total'] = array_sum($netCash) ;
		$result['cash_expenses'][__('Accumulated Net Cash (+/-)')]['total'] = $this->formatAccumulatedNetCash($netCash,$weeks);
	
		
		
		if($returnResultAsArray){
			return [
				'result'=>$result , 
				'dates'=>$dates,
			] ;
		}
		$allCurrencies = [$currency];
		$finalResult[$currency] = $result;
		$pastDueCustomerInvoicesPerCurrency[$currency]=$pastDueCustomerInvoices;
		$customerDueInvoicesPerCurrency[$currency] = $customerDueInvoices;
		return view('admin.reports.contract-cash-flow-report',[
		// return view('admin.reports.cash-flow-report',[
			'weeks'=>$weeks,
			'allCurrencies'=>$allCurrencies,
			// 'result'=>$result,
			'finalResult'=>$finalResult,
			'dates'=>$dates,
			'pastDueCustomerInvoices'=>$pastDueCustomerInvoicesPerCurrency,
			'customerDueInvoices'=>$customerDueInvoicesPerCurrency,
			'months'=>$months ,
			'days'=>$days,
			'reportInterval'=>$reportInterval,
			'pastDueSupplierInvoices'=>$pastDueSupplierInvoices,
			'supplierDueInvoices'=>$supplierDueInvoices,
			'noRowHeaders'=>$noRowHeaders,
			// 'cashExpenseCategoryNamesArr'=>$cashExpenseCategoryNamesArr
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
	
	
	
	
	


	
	
	public function getPastDueCustomerInvoices(string $invoiceType,string $currency , int $companyId , string $startDate ){
		$fullClassName = '\App\Models\\'.$invoiceType;
		$items  = $fullClassName::where('company_id',$companyId)
		->where('net_balance','>',0)
		->whereIn('invoice_status',['past_due','partially_collected_and_past_due'])
		->where('currency',$currency)->where('invoice_due_date','<',$startDate)->get() ;
		foreach($items as $item){
			$item->net_balance_until_date = $item->getNetBalanceUntil($startDate);
		}
		return $items;
	}
	
	
	
	
	
	
	// protected function getCashExpensesAtDates(int $companyId , string $startDate , string $endDate,string $currency,int $cashExpenseCategoryNameId) 
	// {
	// 	return DB::table('cash_expenses')->where('company_id',$companyId)->whereBetween('payment_date',[$startDate,$endDate])->where('currency',$currency)->where('cash_expense_category_name_id',$cashExpenseCategoryNameId)->sum('paid_amount');
	// }
	public function adjustCustomerDueInvoices(Request $request,Company $company){
		$invoiceType = $request->get('invoiceType');
		foreach($request->get('customer_invoice_id',[]) as $customerInvoiceId){
			$weekStartDate = $request->input('week_start_date.'.$customerInvoiceId);
			$percentage = $request->input('percentage.'.$customerInvoiceId);
			$invoiceAmount = $request->input('invoice_amount.'.$customerInvoiceId);
			$amount = $percentage/100  * $invoiceAmount;
			$first = DB::table('weekly_cashflow_custom_due_invoices')
			->where('company_id',$company->id)
			->where('invoice_id',$customerInvoiceId)
			->where('invoice_type',$invoiceType)->first();
			$data = [
				'company_id'=>$company->id ,
				'invoice_id'=>$customerInvoiceId,
				'invoice_type'=>$invoiceType,
				'week_start_date'=>$weekStartDate,
				'percentage'=>$percentage,
				'amount'=>$amount,
				'company_id'=>$company->id 
			] ;
			if($first){
				DB::table('weekly_cashflow_custom_due_invoices')
				->where('company_id',$company->id)
				->where('invoice_id',$customerInvoiceId)
				->where('invoice_type',$invoiceType)->update($data);
			}else{
				DB::table('weekly_cashflow_custom_due_invoices')->insert($data);
			}
			
		}
		return response()->json([
			'status'=>true ,
			'message'=>'',
			'reloadCurrentPage'=>true 
		]);
	}


}
