<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeeklyCashFlowReportController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		
        return view('reports.weekly_cash_flow_form', compact('company'));
    }
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
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
			$result['Customers Invoices Under Collection'][$currentWeekYear] = $this->getCustomerInvoicesUnderCollectionAtDates($company->id,$startDate , $endDate);
			$currentVal = $result['Customers Invoices Under Collection'][$currentWeekYear] ;
			
			$result['Customers Invoices Under Collection']['total'][$currentYear] = isset($result['Customers Invoices Under Collection']['total'][$currentYear]) ? $result['Customers Invoices Under Collection']['total'][$currentYear] + $currentVal : $currentVal ;
			 
			$dates[$currentWeekYear] = [
				'start_date' => $startDate,
				'end_date'=>$endDate 
			];
		}
		return view('admin.reports.weekly-cash-flow-report',[
			'weeks'=>$weeks,
			'result'=>$result,
			'dates'=>$dates
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
	protected function getCustomerInvoicesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate) 
	{
		$items = CustomerInvoice::where('company_id',$companyId)->whereBetween('invoice_due_date',[$startDate,$endDate])->get();;
		return $items->sum('net_invoice_amount');
	}


}
