<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	use NonBankingService ;
	protected function formatForTheeLineChart(array $items){
		$lineChart = [];
		$barChart = [];
		foreach($items as $key => $arrayItems){
			$previous = 0 ;
			foreach($arrayItems as $year => $value){
				$currentGrowthRate = $previous ? (($value / $previous)-1)*100 : 0   ; 
				$previous = $value ;
				$lineChart[$key][] = [
					'date'=> $year.'-01-01' , 
					'revenue_value'=>number_format($value/1000000,2) ,
					'growth_rate'=>number_format($currentGrowthRate,2)
				];
				if($key != 'all'){
					$value = $value / 1000000;
					$barChart[$year][$key] =  isset($barChart[$year][$key]) ? $barChart[$year][$key] + $value : $value;
					$barChart[$year]['year'] = strval($year);
				}
			}
		}

		$barChart = array_values($barChart);
		
		return [
			'line_chart'=>$lineChart,
			'bar_chart'=>$barChart
		] ;
	}
	protected function generateDashboardData(Study $study , Company $company , bool $isSensitivity = false ):array 
	{
	
		$dateIndexWithDate = app('dateIndexWithDate');
		$formattedExpenses = [];
		$formattedResult = [];
		$yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		$titlesMapping = $study->getProjectionTitles();
		$incomeStatement = (new IncomeStatementController())->index($company,$study,true);
		$resultPerRevenueStreamType = $incomeStatement['resultPerRevenueStreamType']??[];
		
		$chartsFormatted =$this->formatForTheeLineChart($resultPerRevenueStreamType); 
		$lineChart = $chartsFormatted['line_chart'];
		$barChart = $chartsFormatted['bar_chart'];
		$incomeStatement = $incomeStatement['tableDataFormatted'];
		$salesRevenueMainItems = $incomeStatement[0]['main_items']??[]; 
		$costOfServices = $incomeStatement[1]??[]; 
		$grossProfits = $incomeStatement[2]['main_items']??[]; 
		$ebitda = $incomeStatement[7]??[]; 
		$ebit = $incomeStatement[9]??[]; 
		$ebt = $incomeStatement[11]??[]; 
		$netProfit = $incomeStatement[13]??[]; 
		$key =  'data';
		$formattedResult['sales_revenue'] = array_values($salesRevenueMainItems['sales-revenue'][$key]??[]); 
		$formattedResult['growth_rate'] = array_values($salesRevenueMainItems['growth-rate'][$key]??[]); 
		$formattedResult['interest_cogs'] = array_values($costOfServices['sub_items']['Interest Cost'][$key]??[]); 
		$formattedResult['gross_profit'] = array_values($grossProfits['gross-profit'][$key]??[]); 
		$formattedResult['gross_profit_percentage_of_sales'] = array_values($grossProfits['% Of Revenue'][$key]??[]); 
		$formattedResult['ebitda'] = array_values($ebitda['main_items']['ebitda'][$key]??[]); 
		$formattedResult['ebitda_percentage_of_sales'] = array_values($ebitda['main_items']['% Of Revenue'][$key]??[]); 
		$formattedResult['ebit'] = array_values($ebit['main_items']['ebit'][$key]??[]); 
		$formattedResult['ebit_percentage_of_sales'] = array_values($ebit['main_items']['% Of Revenue'][$key]??[]); 
		$formattedResult['ebt'] = array_values($ebt['main_items']['ebt'][$key]??[]); 
		$formattedResult['ebt_percentage_of_sales'] = array_values($ebt['main_items']['% Of Revenue'][$key]??[]); 
		$formattedResult['net_profit'] = array_values($netProfit['main_items']['net-profit'][$key]??[]); 
		$formattedResult['net_profit_percentage_of_sales'] = array_values($netProfit['main_items']['% Of Revenue'][$key]??[]); 
		$expenseOrderIds = [
			1 , 3 , 4 , 5 ,6 
		];
		
		foreach($expenseOrderIds as $expenseOrderId){
			$expenseItem = $incomeStatement[$expenseOrderId];
			$mainItemKeyId = array_keys($expenseItem['main_items'])[0];
			$subItems = $expenseItem['sub_items']??[];
			foreach($subItems as $subItemName => $subItemData){
				$formattedExpenses[$mainItemKeyId][$subItemName] = array_values($subItemData[$key]??[]);
			}
			if(count($subItems)){
				$formattedExpenses[$mainItemKeyId]['total'] = array_values($expenseItem['main_items'][$mainItemKeyId][$key]??[]); 
			}
			
			
		}
		
		return [
			'titlesMapping'=>$titlesMapping,
			'lineChart'=>$lineChart ,
			'barChart'=>$barChart ,
			'formattedResult'=>$formattedResult ,
			'formattedExpenses'=>$formattedExpenses,
			'yearWithItsIndexes'=>$yearWithItsIndexes,
			'dateIndexWithDate'=>$dateIndexWithDate
		];
		
	}
	public function view(Request $request , Company $company,Study $study)
	{
		$withSensitivity = $request->routeIs('view.results.dashboard.with.sensitivity') ;
		$dashboardData = $this->generateDashboardData($study,$company,false);
		$formattedResult = $dashboardData['formattedResult'];
		$formattedExpenses =$dashboardData['formattedExpenses'];
		$lineChart =$dashboardData['lineChart'];
		$titlesMapping =$dashboardData['titlesMapping'];
		$barChart =$dashboardData['barChart'];
		$yearWithItsIndexes = $dashboardData['yearWithItsIndexes'];
		$dateIndexWithDate = $dashboardData['dateIndexWithDate'];
		$sensitivityFormattedResult = [];
		$sensitivityFormattedExpenses=[];
		if($withSensitivity){
			$sensitivityDashboardData = $this->generateDashboardData($study,$company,true );
			$sensitivityFormattedResult = $sensitivityDashboardData['formattedResult'];
			$sensitivityFormattedExpenses = $sensitivityDashboardData['formattedExpenses'];
		}
		$yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
	
		$isYearsStudy = !$study->isMonthlyStudy();
		return view('non_banking_services.dashboard.dashboard',
	[
		'dateIndexWithDate'=>$dateIndexWithDate,
		'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		'model'=>$study,
		'study'=>$study,
		'formattedResult'=>$formattedResult,
		'formattedExpenses'=>$formattedExpenses,
		'lineChart'=>$lineChart,
		'titlesMapping'=>$titlesMapping,
		'lineChart'=>$lineChart,
		'barChart'=>$barChart,
		'yearWithItsIndexes'=>$yearWithItsIndexes,
		'sensitivityFormattedResult'=>$sensitivityFormattedResult,
		'sensitivityFormattedExpenses'=>$sensitivityFormattedExpenses,
		'withSensitivity'=>$withSensitivity,
		'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
		'isYearsStudy'=>$isYearsStudy
	]);
	}
}
