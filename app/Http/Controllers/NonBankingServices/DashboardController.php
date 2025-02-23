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
	public function view(Request $request , Company $company,Study $study)
	{
		$yearIndexWithYear = app('yearIndexWithYear');
		$corporateTaxes = $study->getCorporateTaxesRate() / 100 ;
		$startDate = $study->getStudyStartDate();
		$endDate = $study->getStudyEndDate();
		$formattedExpenses = [];
		$formattedResult = [];
		$salesRevenuePerTypes = [];
		$yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		$monthsWithItsYear = $study->getMonthsWithItsYear($yearWithItsIndexes) ;
		
		$titlesMapping = Study::getProjectionTitles();
		$loanSchedulePayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->selectRaw('portfolio_loan_type,revenue_stream_type,interestAmount')->where('study_id',$study->id)->get()->toArray();
		
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
				$currentInterestRevenue  = $interestRevenues[$currentMonthIndex]??0;
				$currentBankInterestExpense = $bankInterestExpenses[$currentMonthIndex]??0;
				if(!is_null($currentYearIndex)){
					$formattedDirectFactoring['interest_revenue'][$currentYearIndex] = isset($formattedDirectFactoring['interest_revenue'][$currentYearIndex]) ? $formattedDirectFactoring['interest_revenue'][$currentYearIndex] +  $currentInterestRevenue : $currentInterestRevenue;
					$formattedDirectFactoring['bank_interest_expense'][$currentYearIndex] = isset($formattedDirectFactoring['bank_interest_expense'][$currentYearIndex]) ? $formattedDirectFactoring['bank_interest_expense'][$currentYearIndex] +  $currentBankInterestExpense : $currentBankInterestExpense;
					$resultPerRevenueStreamType['direct-factoring'][$currentYearAsString] = $formattedDirectFactoring['interest_revenue'][$currentYearIndex];
					$salesRevenuePerTypes['direct-factoring'][$currentYearIndex] = $resultPerRevenueStreamType['direct-factoring'][$currentYearAsString];
					$salesRevenuePerTypes['total_revenue'][$currentYearIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentYearIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentYearIndex] + $salesRevenuePerTypes['direct-factoring'][$currentYearIndex] : $salesRevenuePerTypes['direct-factoring'][$currentYearIndex];
				}
			}
		}
		
		

		
		$testLoopIndex = 0 ;
		foreach($loanSchedulePayments as $loanSchedulePaymentAsStdClass ){
			$portfolioLoanType = $loanSchedulePaymentAsStdClass->portfolio_loan_type;
			$isPortfolio = $portfolioLoanType == 'portfolio'; 
			$revenueStreamType = $loanSchedulePaymentAsStdClass->revenue_stream_type;
			$interestAmounts = json_decode($loanSchedulePaymentAsStdClass->interestAmount);
			$testLoopIndex ++ ;
			foreach($interestAmounts as $currentMonthIndex => $interestAmount){
				
				$currentYearIndex = $monthsWithItsYear[$currentMonthIndex]??null;
				
				$currentYearAsString = $yearIndexWithYear[$currentYearIndex] ?? null ;
				if(!is_null($currentYearIndex)){
					if($isPortfolio){
						// test function
						
						$salesRevenuePerTypes[$revenueStreamType][$currentYearIndex] =  isset($salesRevenuePerTypes[$revenueStreamType][$currentYearIndex]) ? $salesRevenuePerTypes[$revenueStreamType][$currentYearIndex] + $interestAmount : $interestAmount;
						$salesRevenuePerTypes['total_revenue'][$currentYearIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentYearIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentYearIndex] + $interestAmount : $interestAmount;
				
							 $resultPerRevenueStreamType[$revenueStreamType][$currentYearAsString] = isset($resultPerRevenueStreamType[$revenueStreamType][$currentYearAsString]) ? $resultPerRevenueStreamType[$revenueStreamType][$currentYearAsString] + $interestAmount : $interestAmount;
					//		 $resultPerRevenueStreamType[$revenueStreamType]['total'] = isset($resultPerRevenueStreamType[$revenueStreamType]['total']) ? $resultPerRevenueStreamType[$revenueStreamType]['total'] +  $interestAmount : $interestAmount;
							 
									
							$formattedResult['sales_revenue'][$currentYearIndex] = isset($formattedResult['sales_revenue'][$currentYearIndex]) ? $formattedResult['sales_revenue'][$currentYearIndex] + $interestAmount : $interestAmount ;
	
							$currentDirectFactoringInterestRevenue  =$formattedDirectFactoring['interest_revenue'][$currentYearIndex] ?? 0 ;
							$formattedResult['sales_revenue'][$currentYearIndex] = $formattedResult['sales_revenue'][$currentYearIndex] + $currentDirectFactoringInterestRevenue ;
							$currentSalesRevenue = $formattedResult['sales_revenue'][$currentYearIndex] ;
							$previousSalesRevenue = $formattedResult['sales_revenue'][$currentYearIndex-1] ?? 0 ;
							$formattedResult['growth_rate'][$currentYearIndex] = $previousSalesRevenue ? (($currentSalesRevenue / $previousSalesRevenue)-1)*100 : 0 ;
						}else{
							$formattedResult['interest_cogs'][$currentYearIndex] = isset($formattedResult['interest_cogs'][$currentYearIndex]) ? $formattedResult['interest_cogs'][$currentYearIndex] + $interestAmount : $interestAmount ;
							$currentDirectFactoringBankInterestExpense = $formattedDirectFactoring['bank_interest_expense'][$currentYearIndex]??0;
							$formattedResult['interest_cogs'][$currentYearIndex] = $formattedResult['interest_cogs'][$currentYearIndex] + $currentDirectFactoringBankInterestExpense;
						
							
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
				if($expenseCategory == 'cost-of-service' && !isset($formattedExpenses[$expenseCategory]['Interest Cost'][$yearIndex])){
					$formattedExpenses[$expenseCategory]['Interest Cost'][$yearIndex]  = $formattedResult['interest_cogs'][$yearIndex]??0 ;
					$currentYearInterestCost = $formattedExpenses[$expenseCategory]['Interest Cost'][$yearIndex];
				}
				if(!isset($formattedExpenses[$expenseCategory]['Manpower Salaries'][$yearIndex])){
					$formattedExpenses[$expenseCategory]['Manpower Salaries'][$yearIndex] = $salaryExpensesForCategory[$expenseCategory][$yearIndex] ?? 0;
					$currentYearManpowerTotal = $formattedExpenses[$expenseCategory]['Manpower Salaries'][$yearIndex];
				}
				$currentExpenseItemTotalPerYear = 0 ;
				foreach($monthIndexWithActive as $monthIndex=> $isActiveIndex){
					$currentExpenseItemTotalPerYear += $monthlyExpenses[$monthIndex]??0 ;
				}
				$formattedExpenses[$expenseCategory][$name][$yearIndex] = $currentExpenseItemTotalPerYear;
		
			//	$totalForAllExpenseCategoryPerName[$yearIndex] =   $currentExpenseItemTotalPerYear ; 
				$currentYearTotal = $currentExpenseItemTotalPerYear + $currentYearInterestCost +$currentYearManpowerTotal;
				$formattedExpenses[$expenseCategory]['total'][$yearIndex] = isset($formattedExpenses[$expenseCategory]['total'][$yearIndex]) ? $formattedExpenses[$expenseCategory]['total'][$yearIndex] + $currentYearTotal:$currentYearTotal    ; 
				
				
				
			}
		
			
		}
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

		return view('non_banking_services.dashboard.dashboard',
	[
		'startDate'=>$startDate,
		'endDate'=>$endDate,
		'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		'model'=>$study,
		'study'=>$study,
		'formattedResult'=>$formattedResult,
		'formattedExpenses'=>$formattedExpenses,
		'lineChart'=>$lineChart,
		'titlesMapping'=>$titlesMapping,
		'lineChart'=>$lineChart,
		'barChart'=>$barChart,
		'resultPerRevenueStreamType'=>$resultPerRevenueStreamType,
		'yearWithItsIndexes'=>$yearWithItsIndexes
	]);
	}
}
