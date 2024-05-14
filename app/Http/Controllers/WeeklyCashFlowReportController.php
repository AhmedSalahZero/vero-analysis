<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\PayableCheque;
use App\Models\SupplierInvoice;
use App\ReadyFunctions\InvoiceAgingService;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeeklyCashFlowReportController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
        return view('reports.weekly_cash_flow_form', compact('company'));
    }
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
		$currency = $request->get('currency');
		$year = explode('-',$startDate)[0];
		$endDate  = $request->get('end_date');
		$datesWithWeeks = getWeekNumberBetweenDates($year , Carbon::make($endDate));
		$weeks  = $this->mergeYearWithWeek($datesWithWeeks ,Carbon::make($startDate) );
		$firstIndex = array_key_first($weeks);
		$lastIndex = array_key_last($weeks);
		$dates = [];
		$rangedWeeks = [];
		foreach($weeks as $currentWeekYear=>$week){
			$currentYear = explode('-',$currentWeekYear)[1];
			if($currentWeekYear == $firstIndex){
				$startDate = $startDate ;
				$endDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['end_date'];
			}
			elseif($currentWeekYear == $lastIndex){
				$startDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['start_date'];
				$endDate = $request->get('end_date');  
			}
			else
			{
				$rangedWeeks = getMinDateOfWeek($datesWithWeeks,$week,$currentYear);
				$startDate = $rangedWeeks['start_date'];
				$endDate = $rangedWeeks['end_date'];
			}
			
			$result['Cheques Under Collection'][$currentWeekYear] = $this->getChequesCollectedUnderDates($company->id,$startDate , $endDate,$currency,Cheque::UNDER_COLLECTION,'expected_collection_date');
			$result['Checks Collected'][$currentWeekYear] = $this->getChequesCollectedUnderDates($company->id,$startDate , $endDate,$currency,Cheque::COLLECTED,'actual_collection_date');
			$result['Customers Invoices'][$currentWeekYear] = $this->getCustomerInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$result['Incoming Transfers'][$currentWeekYear] = $this->getIncomingTransferUnderDates($company->id,$startDate , $endDate,$currency);
			$result['Bank Deposits'][$currentWeekYear] = $this->getBankDepositsUnderDates($company->id,$startDate , $endDate,$currency);
			$result['Cash Collections'][$currentWeekYear] = $this->getCashInSafeUnderDates($company->id,$startDate , $endDate,$currency);
			$result['Customers Past Due Invoices'] = [];
			$result['Cheques In Safe'][$currentWeekYear] = $this->getChequesCollectedUnderDates($company->id,$startDate , $endDate,$currency,Cheque::IN_SAFE,'due_date');
			$result['Outgoing Transfers'][$currentWeekYear] = $this->getOutgoingTransfersAtDates($company->id,$startDate , $endDate,$currency);
			$result['Cash Payments'][$currentWeekYear] = $this->getCashPaymentsAtDates($company->id,$startDate , $endDate,$currency);
			$result['Paid Payable Cheques'][$currentWeekYear] = $this->getSupplierPayableChequesAtDates($company->id,$startDate , $endDate,$currency,PayableCheque::PAID,'actual_payment_date');
			$result['Under Payment Payable Cheques'][$currentWeekYear] = $this->getSupplierPayableChequesAtDates($company->id,$startDate , $endDate,$currency,PayableCheque::PENDING,'due_date');
			// $result['Cheques Under Collection'][$currentWeekYear] = $this->getCustomerChequesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$result['Suppliers Invoices'][$currentWeekYear] = $this->getSupplierInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$result['Suppliers Past Due Invoices'] = [];
			// $result['S Invoices Under Collection'][$currentWeekYear] = $this->getCustomerInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$currentVal = $result['Customers Invoices'][$currentWeekYear] ;
			
			$result['Customers Invoices']['total'][$currentYear] = isset($result['Customers Invoices']['total'][$currentYear]) ? $result['Customers Invoices']['total'][$currentYear] + $currentVal : $currentVal ;
			 
			$dates[$currentWeekYear] = [
				'start_date' => $startDate,
				'end_date'=>$endDate 
			];
		}
		// for customers 
		$pastDueCustomerInvoices = $this->getPastDueCustomerInvoices('CustomerInvoice',$currency,$company->id,$request->get('start_date'));
		$excludeIds = $pastDueCustomerInvoices->where('net_balance_until_date','<=',0)->pluck('id')->toArray() ;
		$customerDueInvoices=DB::table('weekly_cashflow_custom_due_invoices')->where('company_id',$company->id)
		->where('invoice_type','CustomerInvoice')
		->whereNotIn('invoice_id',$excludeIds)
		->groupBy('week_start_date')->selectRaw('week_start_date,sum(amount) as amount')->get();
		
		
		
		// for suppliers 
		$pastDueSupplierInvoices = $this->getPastDueCustomerInvoices('SupplierInvoice',$currency,$company->id,$request->get('start_date'));
		$excludeIds = $pastDueSupplierInvoices->where('net_balance_until_date','<=',0)->pluck('id')->toArray() ;
		$supplierDueInvoices=DB::table('weekly_cashflow_custom_due_invoices')->where('company_id',$company->id)
		->where('invoice_type','SupplierInvoice')
		->whereNotIn('invoice_id',$excludeIds)
		->groupBy('week_start_date')->selectRaw('week_start_date,sum(amount) as amount')->get();
		
		
		return view('admin.reports.weekly-cash-flow-report',[
			'weeks'=>$weeks,
			'result'=>$result,
			'dates'=>$dates,
			'pastDueCustomerInvoices'=>$pastDueCustomerInvoices,
			'customerDueInvoices'=>$customerDueInvoices,
			
			'pastDueSupplierInvoices'=>$pastDueSupplierInvoices,
			'supplierDueInvoices'=>$supplierDueInvoices
		]);
	}
	protected function mergeYearWithWeek(array $weeks , Carbon $startDate ):array{
		$newWeeks = [];
		if(!count($weeks)){
			return [];
		}
		foreach($weeks as $date => $weekNumber){
			// dump($date);
			$currentDate =Carbon::make($date);
				$year = $currentDate->year ;
				if($currentDate->greaterThanOrEqualTo($startDate)){
					$newWeeks[$weekNumber.'-'.$year] = $weekNumber; 
				}
			
		}
		return $newWeeks;
		
	}
	protected function getCustomerInvoicesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		$items = CustomerInvoice::where('company_id',$companyId)->where('currency',$currency)
		->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		return $items->sum('net_invoice_amount');
	}
	protected function getChequesCollectedUnderDates(int $companyId , string $startDate , string $endDate,string $currency,string $chequeStatus,string $dateColumnName) 
	{
		return  DB::table('money_received')
		->where('type',MoneyReceived::CHEQUE)
		->where('currency',$currency)
		->join('cheques','cheques.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('cheques.'.$dateColumnName,[$startDate,$endDate])
		->where('cheques.status',$chequeStatus)
		->sum('received_amount');
	}
	
	protected function getIncomingTransferUnderDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return  DB::table('money_received')
		->where('type',MoneyReceived::INCOMING_TRANSFER)
		->where('currency',$currency)
		->join('incoming_transfers','incoming_transfers.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('money_received.receiving_date',[$startDate,$endDate])
		->sum('received_amount');
	}
	
	protected function getBankDepositsUnderDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return  DB::table('money_received')
		->where('type',MoneyReceived::CASH_IN_BANK)
		->where('currency',$currency)
		->join('cash_in_banks','cash_in_banks.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('money_received.receiving_date',[$startDate,$endDate])
		->sum('received_amount');
	}
	protected function getCashInSafeUnderDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return  DB::table('money_received')
		->where('type',MoneyReceived::CASH_IN_SAFE)
		->where('currency',$currency)
		->join('cash_in_safes','cash_in_safes.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('money_received.receiving_date',[$startDate,$endDate])
		->sum('received_amount');
	}
	
	// protected function getCustomerChequesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	// {
	// 	return DB::table('cheques')->where('status',Cheque::UNDER_COLLECTION)
	// 	->where('currency',$currency)
	// 	->where('cheques.company_id',$companyId)
	// 	->whereBetween('expected_collection_date',[$startDate,$endDate])
	// 	->join('money_received','money_received_id','money_received.id')
	// 	->sum('received_amount');
	// }
	// protected function getCustomerChequesInSafeAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	// {
	// 	return DB::table('cheques')->where('status',Cheque::IN_SAFE)
	// 	->where('currency',$currency)
	// 	->where('cheques.company_id',$companyId)
	// 	->whereBetween('due_date',[$startDate,$endDate])
	// 	->join('money_received','money_received_id','money_received.id')
	// 	->sum('received_amount');
	// }
	public function getPastDueCustomerInvoices(string $invoiceType,string $currency , int $companyId , string $startDate ){
		$fullClassName = '\App\Models\\'.$invoiceType;
		$items  = $fullClassName::where('company_id',$companyId)->where('currency',$currency)->where('invoice_due_date','<',$startDate)->get() ;
		foreach($items as $item){
			$item->net_balance_until_date = $item->getNetBalanceUntil($startDate);
		}
		return $items;
	}
	protected function getSupplierPayableChequesAtDates(int $companyId , string $startDate , string $endDate,string $currency,$chequeStatus , $dateFieldName) 
	{
		return DB::table('payable_cheques')->where('status',$chequeStatus)
		->where('currency',$currency)
		->where('type',MoneyPayment::PAYABLE_CHEQUE)
		->where('payable_cheques.company_id',$companyId)
		->whereBetween($dateFieldName,[$startDate,$endDate])
		->join('money_payments','money_payment_id','money_payments.id')
		->sum('paid_amount');
	}
	
	protected function getCashPaymentsAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return DB::table('cash_payments')
		->where('currency',$currency)
		->where('type',MoneyPayment::CASH_PAYMENT)
		->where('money_payments.company_id',$companyId)
		->whereBetween('delivery_date',[$startDate,$endDate])
		->join('money_payments','money_payment_id','money_payments.id')
		->sum('paid_amount');
	}
	protected function getOutgoingTransfersAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return DB::table('outgoing_transfers')
		->where('currency',$currency)
		->where('type',MoneyPayment::OUTGOING_TRANSFER)
		->where('money_payments.company_id',$companyId)
		->whereBetween('delivery_date',[$startDate,$endDate])
		->join('money_payments','money_payment_id','money_payments.id')
		->sum('paid_amount');
	}
	
	protected function getSupplierInvoicesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		$items = SupplierInvoice::where('company_id',$companyId)->where('currency',$currency)->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		return $items->sum('net_invoice_amount');
	}
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
