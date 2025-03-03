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
		$loanSchedulePaymentTableName =  $isSensitivity ? 'sensitivity_loan_schedule_payments' : 'loan_schedule_payments';
		
		$yearIndexWithYear = app('yearIndexWithYear');
		$corporateTaxes = $study->getCorporateTaxesRate() / 100 ;
		// $startDate = $study->getStudyStartDate();
		// $endDate = $study->getStudyEndDate();
		$formattedExpenses = [];
		$formattedResult = [];
		$salesRevenuePerTypes = [];
		$yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		$monthsWithItsYear = $study->getMonthsWithItsYear($yearWithItsIndexes) ;
		
		$titlesMapping = Study::getProjectionTitles();
		$loanSchedulePayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table($loanSchedulePaymentTableName)->selectRaw('portfolio_loan_type,revenue_stream_type,interestAmount')->where('study_id',$study->id)->get()->toArray();
		
		$resultPerRevenueStreamType = [
			'all'=>[]
		];

		$directFactoringBreakdown = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('direct_factoring_breakdowns')
		->where('study_id',$study->id)
		->selectRaw('interest_revenue,bank_interest_expense')->get()->toArray();
		$formattedDirectFactoring = [];
		
		foreach($directFactoringBreakdown as $currentDirectFactoringBreakdown){
			$interestRevenues= (array)json_decode($currentDirectFactoringBreakdown->interest_revenue);
			$bankInterestExpenses= (array)json_decode($currentDirectFactoringBreakdown->bank_interest_expense);
			foreach($monthsWithItsYear as $currentMonthIndex => $currentYearIndex)
			{
				$currentYearIndex = $monthsWithItsYear[$currentMonthIndex]??null;
				$currentYearAsString = $yearIndexWithYear[$currentYearIndex]??null;
				$currentInterestRevenueAtMonthIndex  = $interestRevenues[$currentMonthIndex]??0;
				$currentBankInterestExpenseAtMonthIndex = $bankInterestExpenses[$currentMonthIndex]??0;
				if(!is_null($currentYearIndex)){
					$formattedDirectFactoring['interest_revenue'][$currentYearIndex] = isset($formattedDirectFactoring['interest_revenue'][$currentYearIndex]) ? $formattedDirectFactoring['interest_revenue'][$currentYearIndex] +  $currentInterestRevenueAtMonthIndex : $currentInterestRevenueAtMonthIndex;
					$formattedDirectFactoring['bank_interest_expense'][$currentYearIndex] = isset($formattedDirectFactoring['bank_interest_expense'][$currentYearIndex]) ? $formattedDirectFactoring['bank_interest_expense'][$currentYearIndex] +  $currentBankInterestExpenseAtMonthIndex : $currentBankInterestExpenseAtMonthIndex;
					$resultPerRevenueStreamType['direct-factoring'][$currentYearAsString] = $formattedDirectFactoring['interest_revenue'][$currentYearIndex];
			    	$salesRevenuePerTypes['direct-factoring'][$currentYearIndex] = $resultPerRevenueStreamType['direct-factoring'][$currentYearAsString];
					$salesRevenuePerTypes['total_revenue'][$currentYearIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentYearIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentYearIndex] + $currentInterestRevenueAtMonthIndex : $currentInterestRevenueAtMonthIndex + $resultPerRevenueStreamType['direct-factoring'][$currentYearAsString];
				}
			}
		}

		// $loanSchedulePayments = [];
		$testLoopIndex = 0 ;
		// dd(collect($loanSchedulePayments)->where('revenue_stream_type',Study::PORTFOLIO_MORTGAGE)->toArray());
		foreach($loanSchedulePayments as $loanSchedulePaymentAsStdClass ){
			$portfolioLoanType = $loanSchedulePaymentAsStdClass->portfolio_loan_type;
			$isPortfolio = $portfolioLoanType == 'portfolio'; 
			$revenueStreamType = $loanSchedulePaymentAsStdClass->revenue_stream_type;
			$interestAmounts = json_decode($loanSchedulePaymentAsStdClass->interestAmount);
			$testLoopIndex ++ ;
			foreach($interestAmounts as $currentMonthIndex => $interestAmountAtMonthIndex){
				
				$currentYearIndex = $monthsWithItsYear[$currentMonthIndex]??null;
				$currentDirectFactoringBankInterestExpenseAtYearIndex = $formattedDirectFactoring['bank_interest_expense'][$currentYearIndex]??0;
				$currentYearAsString = $yearIndexWithYear[$currentYearIndex] ?? null ;
				if(!is_null($currentYearIndex)){
					if($isPortfolio){
						$salesRevenuePerTypes[$revenueStreamType][$currentYearIndex] =  isset($salesRevenuePerTypes[$revenueStreamType][$currentYearIndex]) ? $salesRevenuePerTypes[$revenueStreamType][$currentYearIndex] + $interestAmountAtMonthIndex : $interestAmountAtMonthIndex;
						$salesRevenuePerTypes['total_revenue'][$currentYearIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentYearIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentYearIndex] + $interestAmountAtMonthIndex : $interestAmountAtMonthIndex;
						$formattedResult['sales_revenue'][$currentYearIndex] = $salesRevenuePerTypes['total_revenue'][$currentYearIndex] ;
							 $resultPerRevenueStreamType[$revenueStreamType][$currentYearAsString] = isset($resultPerRevenueStreamType[$revenueStreamType][$currentYearAsString]) ? $resultPerRevenueStreamType[$revenueStreamType][$currentYearAsString] + $interestAmountAtMonthIndex : $interestAmountAtMonthIndex;
							$currentSalesRevenue = $formattedResult['sales_revenue'][$currentYearIndex]??0 ;
							$previousSalesRevenue = $formattedResult['sales_revenue'][$currentYearIndex-1] ?? 0 ;
							$formattedResult['growth_rate'][$currentYearIndex] = $previousSalesRevenue ? (($currentSalesRevenue / $previousSalesRevenue)-1)*100 : 0 ;
						}else{			
							$formattedResult['interest_cogs'][$currentYearIndex] = isset($formattedResult['interest_cogs'][$currentYearIndex]) ? $formattedResult['interest_cogs'][$currentYearIndex] + $interestAmountAtMonthIndex : $interestAmountAtMonthIndex + $currentDirectFactoringBankInterestExpenseAtYearIndex ;
						}
					}
				}
			
		}
		$salaryExpenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('departments')
		->join('positions','positions.department_id','=','departments.id')
		->selectRaw('expense_type,salary_expenses,expense_type')->where('type','manpower')->where('departments.study_id',$study->id)->get() ;
		$expenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('expenses')->selectRaw('expense_category,name,relation_name,monthly_repeating_amounts,expense_as_percentages,payload')->where('model_id',$study->id)->where('model_name','Study')->get()->toArray();
		$columnPerTypes = [
			'one_time_expense'=>'payload',
			'percentage_of_sales'=>'expense_as_percentages',
			'fixed_monthly_repeating_amount'=>'monthly_repeating_amounts',
		];
		$salaryExpensesForCategory = [];
		foreach($salaryExpenses as $salaryExpense){
			$expenseCategory = $salaryExpense->expense_type;
			$salaryExpensePayload = json_decode($salaryExpense->salary_expenses);
			foreach($monthsWithItsYear as $monthIndex => $yearIndex){
				$currentSalaryExpense = $salaryExpensePayload[$monthIndex];
				$salaryExpensesForCategory[$expenseCategory][$yearIndex] = isset($salaryExpensesForCategory[$expenseCategory][$yearIndex]) ?  $salaryExpensesForCategory[$expenseCategory][$yearIndex] + $currentSalaryExpense : $currentSalaryExpense;
			}
		}

		
		foreach($expenses as $expense){
		
			$name = $expense->name;
			$relationName = $expense->relation_name;
			$expenseCategory = $expense->expense_category;
			$currentColumnName = $columnPerTypes[$relationName];
			$monthlyExpenses = (array)json_decode($expense->{$currentColumnName});
			foreach($yearWithItsIndexes as $yearIndex => $monthIndexWithActive){
				$currentYearInterestCost = 0 ;
				$currentYearManpowerTotal = 0 ;
				$currentExpenseItemTotalPerYear = 0 ;
				if($expenseCategory == 'cost-of-service' && !isset($formattedExpenses[$expenseCategory]['Interest Cost'][$yearIndex])){
					$formattedExpenses[$expenseCategory]['Interest Cost'][$yearIndex]  = $formattedResult['interest_cogs'][$yearIndex]??0 ;
					$currentYearInterestCost = $formattedExpenses[$expenseCategory]['Interest Cost'][$yearIndex];
				}
				if(!isset($formattedExpenses[$expenseCategory]['Manpower Salaries'][$yearIndex])){
					$formattedExpenses[$expenseCategory]['Manpower Salaries'][$yearIndex] = $salaryExpensesForCategory[$expenseCategory][$yearIndex] ?? 0;
					$currentYearManpowerTotal = $formattedExpenses[$expenseCategory]['Manpower Salaries'][$yearIndex];
				}
				
				foreach($monthIndexWithActive as $monthIndex=> $isActiveIndex){
					// dump('month value',$monthlyExpenses[$monthIndex]??0,'month index',$monthIndex,'loop year',$yearIndex);
					// if($yearIndex == 2 ){
						// dump($monthIndex,$monthlyExpenses[$monthIndex]??0);
						$currentExpenseItemTotalPerYear += $monthlyExpenses[$monthIndex]??0 ;
					// }
				}
				// dump('year index',$yearIndex,'per year ',$currentExpenseItemTotalPerYear,'--');
				$formattedExpenses[$expenseCategory][$name][$yearIndex] = $currentExpenseItemTotalPerYear;
				$currentYearTotal = $currentExpenseItemTotalPerYear + $currentYearInterestCost +$currentYearManpowerTotal;
				$formattedExpenses[$expenseCategory]['total'][$yearIndex] = isset($formattedExpenses[$expenseCategory]['total'][$yearIndex]) ? $formattedExpenses[$expenseCategory]['total'][$yearIndex] + $currentYearTotal:$currentYearTotal    ; 
			}
		
			
		}
		// dd($formattedExpenses);
		// dd($formattedExpenses);
		foreach($yearWithItsIndexes as $yearIndex => $monthWithItsIndexes){
			$currentYearAsString = $yearIndexWithYear[$yearIndex] ?? null ;
			$currentSalesRevenue = $formattedResult['sales_revenue'][$yearIndex]??0;
			$resultPerRevenueStreamType['all'][$currentYearAsString] = $currentSalesRevenue;
			// $currentInterestCogs = $formattedResult['interest_cogs'][$yearIndex]??0;
			$costOfServiceAtYearIndex = $formattedExpenses['cost-of-service']['total'][$yearIndex]??0;
			$formattedResult['gross_profit'][$yearIndex] = $currentSalesRevenue - $costOfServiceAtYearIndex;
			$formattedResult['gross_profit_percentage_of_sales'][$yearIndex] = $currentSalesRevenue ? $formattedResult['gross_profit'][$yearIndex] / $currentSalesRevenue *100 : 0 ;
			$currentOPEXExpense =$formattedExpenses['other-operation-expense']['total'][$yearIndex]??0; 
			$currentMarketingExpense =$formattedExpenses['marketing-expense']['total'][$yearIndex]??0; 
			$currentSalesExpense =$formattedExpenses['sales-expense']['total'][$yearIndex]??0; 
			$currentGeneralExpense =$formattedExpenses['general-expense']['total'][$yearIndex]??0; 
			$currentDepreciationExpense =$formattedExpenses['depreciation-expense']['total'][$yearIndex]??0; 
			$currentEbitdaAtYearIndex = $currentSalesRevenue  - $costOfServiceAtYearIndex - $currentOPEXExpense - $currentMarketingExpense - $currentSalesExpense-$currentGeneralExpense+$currentDepreciationExpense;
			$formattedResult['ebitda'][$yearIndex] = $currentEbitdaAtYearIndex;
			$formattedResult['ebitda_percentage_of_sales'][$yearIndex] =$currentSalesRevenue ?  $currentEbitdaAtYearIndex / $currentSalesRevenue *100 :0;
			$currentEbitAtYearIndex = $currentEbitdaAtYearIndex -  $currentDepreciationExpense;
			$formattedResult['ebit'][$yearIndex] = $currentEbitAtYearIndex;
			$formattedResult['ebit_percentage_of_sales'][$yearIndex] =$currentSalesRevenue ?  $currentEbitAtYearIndex / $currentSalesRevenue *100 :0;
			$currentFinanceInterestExpense = $formattedExpenses['financial-interest-expense']['total'][$yearIndex]??0;
			$currentEbtAtYearIndex = $currentEbitAtYearIndex - $currentFinanceInterestExpense ;
			$formattedResult['ebt'][$yearIndex] = $currentEbtAtYearIndex;
			$formattedResult['ebt_percentage_of_sales'][$yearIndex] =$currentSalesRevenue ?  $currentEbtAtYearIndex / $currentSalesRevenue *100 :0;
			$formattedResult['net_profit'][$yearIndex] = $currentEbtAtYearIndex <0 ? $currentEbtAtYearIndex :$currentEbtAtYearIndex * (1-$corporateTaxes)  ;  
			$formattedResult['net_profit_percentage_of_sales'][$yearIndex] = $currentSalesRevenue ? $formattedResult['net_profit'][$yearIndex] / $currentSalesRevenue  *100 :0 ;  
			
		}
		$chartsFormatted =$this->formatForTheeLineChart($resultPerRevenueStreamType); 
		$lineChart = $chartsFormatted['line_chart'];
		$barChart = $chartsFormatted['bar_chart'];
		
		return [
			'titlesMapping'=>$titlesMapping,
			'lineChart'=>$lineChart ,
			'barChart'=>$barChart ,
			'formattedResult'=>$formattedResult ,
			'formattedExpenses'=>$formattedExpenses,
			'yearWithItsIndexes'=>$yearWithItsIndexes
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
		$sensitivityFormattedResult = [];
		$sensitivityFormattedExpenses=[];
		if($withSensitivity){
			$sensitivityDashboardData = $this->generateDashboardData($study,$company,true );
			$sensitivityFormattedResult = $sensitivityDashboardData['formattedResult'];
			$sensitivityFormattedExpenses = $sensitivityDashboardData['formattedExpenses'];
		}
		
		return view('non_banking_services.dashboard.dashboard',
	[
		// 'startDate'=>$startDate,
		// 'endDate'=>$endDate,
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
		'withSensitivity'=>$withSensitivity
	]);
	}
}
