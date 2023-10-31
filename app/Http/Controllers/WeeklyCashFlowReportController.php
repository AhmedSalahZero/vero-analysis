<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\CustomerDueCollectionAnalysis;
use App\Models\SalesGathering;
use App\ReadyFunctions\InvoiceAgingService;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeeklyCashFlowReportController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		// $customerNames = DB::table('customer_due_collection_analysis')->where('company_id',$company->id)
		// ->selectRaw('customer_name')->get()->pluck('customer_name')->unique()->values()->toArray();
		
        return view('reports.weekly_cash_flow_form', compact('company'));
    }
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
		$year = explode('-',$startDate)[0];
		$endDate  = $request->get('end_date');
		$datesWithWeeks = getWeekNumberBetweenDates($year , Carbon::make($endDate));
		// dd($datesWithWeeks);
		// dd($datesWithWeeks);
		$startDateWeekNumber = $datesWithWeeks[$startDate];
		// $endDateWeekNumber = $datesWithWeeks[$endDate];
		// dd($startDateWeekNumber,$endDateWeekNumber,$datesWithWeeks);
		// $weeks = range($startDateWeekNumber,$endDateWeekNumber) ;
		$weeks  = $this->mergeYearWithWeek($datesWithWeeks ,Carbon::make($startDate) );
		$firstIndex = array_key_first($weeks);
		$lastIndex = array_key_last($weeks);
		// $currentWeekYear = 2023;
		$dates = [];
		$rangedWeeks = [];
		// dd($firstIndex,$lastIndex , $weeks);
		foreach($weeks as $currentWeekYear=>$week){
			$currentYear = explode('-',$currentWeekYear)[1];
			if($currentWeekYear == $firstIndex){
				// dump('first ',$firstIndex);
				$startDate = $startDate ;
				// dd($datesWithWeeks , $currentWeekYear);
				// dd($datesWithWeeks);
				$endDate = getMinDateOfWeek($datesWithWeeks,$week,$currentYear)['end_date'];
				// dd($datesWithWeeks ,$week );
				// dd($endDate);
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
		// dd();
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
		$items = CustomerDueCollectionAnalysis::where('company_id',$companyId)->whereBetween('invoice_due_date',[$startDate,$endDate])->get();;
		return $items->sum('net_invoice_amount');
	}


}
