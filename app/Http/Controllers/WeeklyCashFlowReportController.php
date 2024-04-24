<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\PayableCheque;
use App\Models\SupplierInvoice;
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
			
			$result['Customers Invoices'][$currentWeekYear] = $this->getCustomerInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$result['Cheques In Safe'][$currentWeekYear] = $this->getCustomerChequesInSafeAtDates($company->id,$startDate , $endDate,$currency);
			$result['Payable Cheques'][$currentWeekYear] = $this->getSupplierPayableChequesAtDates($company->id,$startDate , $endDate,$currency);
			$result['Cheques Under Collection'][$currentWeekYear] = $this->getCustomerChequesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$result['Suppliers Invoices'][$currentWeekYear] = $this->getSupplierInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			// $result['S Invoices Under Collection'][$currentWeekYear] = $this->getCustomerInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate,$currency);
			$currentVal = $result['Customers Invoices'][$currentWeekYear] ;
			
			$result['Customers Invoices']['total'][$currentYear] = isset($result['Customers Invoices']['total'][$currentYear]) ? $result['Customers Invoices']['total'][$currentYear] + $currentVal : $currentVal ;
			 
			$dates[$currentWeekYear] = [
				'start_date' => $startDate,
				'end_date'=>$endDate 
			];
		}
		$pastDueCustomerInvoices = $this->getPastDueCustomerInvoices($currency,$company->id);
		
		return view('admin.reports.weekly-cash-flow-report',[
			'weeks'=>$weeks,
			'result'=>$result,
			'dates'=>$dates,
			'pastDueCustomerInvoices'=>$pastDueCustomerInvoices
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
		$items = CustomerInvoice::where('company_id',$companyId)->where('currency',$currency)->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		return $items->sum('net_invoice_amount');
	}
	protected function getCustomerChequesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return DB::table('cheques')->where('status',Cheque::UNDER_COLLECTION)
		->where('currency',$currency)
		->where('cheques.company_id',$companyId)
		->whereBetween('expected_collection_date',[$startDate,$endDate])
		->join('money_received','money_received_id','money_received.id')
		->sum('received_amount');
	}
	protected function getCustomerChequesInSafeAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return DB::table('cheques')->where('status',Cheque::IN_SAFE)
		->where('currency',$currency)
		->where('cheques.company_id',$companyId)
		->whereBetween('due_date',[$startDate,$endDate])
		->join('money_received','money_received_id','money_received.id')
		->sum('received_amount');
	}
	public function getPastDueCustomerInvoices(string $currency , int $companyId ){
		 return DB::table('customer_invoices')->where('company_id',$companyId)->where('currency',$currency)->where('invoice_status','past_due')->get();
	}
	protected function getSupplierPayableChequesAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		
		return DB::table('payable_cheques')->where('status',PayableCheque::PENDING)
		->where('currency',$currency)
		->where('payable_cheques.company_id',$companyId)
		->whereBetween('due_date',[$startDate,$endDate])
		->join('money_payments','money_payment_id','money_payments.id')
		->sum('paid_amount');
	}
	protected function getSupplierInvoicesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		$items = SupplierInvoice::where('company_id',$companyId)->where('currency',$currency)->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		return $items->sum('net_invoice_amount');
	}


}
