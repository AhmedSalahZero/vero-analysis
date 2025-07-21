<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Study;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeStatementController extends Controller
{
    public function index(Company $company , Request $request,Study $study){
		$start = microtime(true);
		$dateIndexWithDate = app('dateIndexWithDate');
	//	$yearIndexWithYear = app('yearIndexWithYear');
		$corporateTaxes = $study->getCorporateTaxesRate() / 100 ;
//		$startDate = $study->getStudyStartDate();
//		$endDate = $study->getStudyEndDate();
		$formattedExpenses = [];
		$formattedResult = [];
		$salesRevenuePerTypes = [];
		$yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		$monthsWithItsYear = $study->getMonthsWithItsYear($yearWithItsIndexes) ;
		$tableDataFormatted = [];
		$expenseMainTitlesMapping = getExpenseTypes(); 
		$loanSchedulePayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->selectRaw('portfolio_loan_type,revenue_stream_type,interestAmount')->where('study_id',$study->id)->get()->toArray();
		$defaultNumericInputClasses = [
			'number-format-decimals'=>0,
			'is-percentage'=>false,
			'classes'=>'repeater-with-collapse-input',
			'formatted-input-classes'=>'custom-input-numeric-width ',
		];
		$defaultPercentageInputClasses = [
			'classes'=>'',
			'formatted-input-classes'=>'',
			'is-percentage'=>true ,
			'number-format-decimals'=> 2,
		];
		$defaultClasses = [
			$defaultNumericInputClasses,
			$defaultPercentageInputClasses 
		];
		$orderIndexPerExpenseCategory = [
			// 'sales_revenue'=>0,
			'cost-of-service'=>1 ,
			'gross-profit'=>2 ,
			'other-operation-expense'=>3,
			'marketing-expense'=>4 ,
			'sales-expense'=>5,
			'general-expense'=>6,
			'ebitda'=>7,
			'ebit'=>8,
			'ebt'=>9,
			'net-profit'=>10
		];
		$financialYearsEndMonths = $study->getFinancialYearsEndMonths();
		$grossProfitOrderIndex = $orderIndexPerExpenseCategory['gross-profit']; 
		$ebitdaOrderIndex = $orderIndexPerExpenseCategory['ebitda']; 
		$ebitOrderIndex = $orderIndexPerExpenseCategory['ebit']; 
		$ebtOrderIndex = $orderIndexPerExpenseCategory['ebt']; 
		$netProfitOrderIndex = $orderIndexPerExpenseCategory['net-profit']; 
		
		
		$tableDataFormatted[0]['main_items']['sales-revenue']['options'] = array_merge([
			'title'=>__('Sales Revenue')
		],$defaultNumericInputClasses);
		
		$tableDataFormatted[0]['main_items']['growth-rate']['options'] = array_merge($defaultPercentageInputClasses,['title'=>__('Growth Rate %')]);
		$tableDataFormatted[0]['sub_items']['leasing']['options'] =array_merge([
			'title'=>__('leasing'),
		],$defaultNumericInputClasses);
		
		$tableDataFormatted[0]['sub_items']['direct-factoring']['options'] =array_merge([
			'title'=>__('Direct Factoring'),
		],$defaultNumericInputClasses);
		
		$tableDataFormatted[0]['sub_items']['ijara']['options'] =array_merge([
			'title'=>__('Ijara Mortgage'),
		],$defaultNumericInputClasses);
		
		$tableDataFormatted[0]['sub_items'][Study::PORTFOLIO_MORTGAGE]['options'] =array_merge([
			'title'=>__('Portfolio Mortgage'),
		],$defaultNumericInputClasses);
		

		
		$tableDataFormatted[0]['sub_items']['reverse-factoring']['options'] =array_merge([
			'title'=>__('Reverse Factoring'),
		],$defaultNumericInputClasses);
	
		$tableDataFormatted[0]['sub_items'][Study::MiCROFINANCE]['options'] =array_merge([
			'title'=>__('Microfinance'),
		],$defaultNumericInputClasses);
		
		$tableDataFormatted[$grossProfitOrderIndex]['main_items']['gross-profit']['options']['title'] = __('Gross Profit');
		$tableDataFormatted[$grossProfitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
		
		$tableDataFormatted[$ebitdaOrderIndex]['main_items']['ebitda']['options']['title'] = __('EBITDA');
		$tableDataFormatted[$ebitdaOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
		
		$tableDataFormatted[$ebitOrderIndex]['main_items']['ebit']['options']['title'] = __('EBIT');
		$tableDataFormatted[$ebitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
		
		$tableDataFormatted[$ebtOrderIndex]['main_items']['ebt']['options']['title'] = __('EBT');
		$tableDataFormatted[$ebtOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
		$tableDataFormatted[$netProfitOrderIndex]['main_items']['net-profit']['options']['title'] = __('Net Profit');
		$tableDataFormatted[$netProfitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
		
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
				$currentMonthAsString = $dateIndexWithDate[$currentMonthIndex];
				$currentInterestRevenue  = $interestRevenues[$currentMonthIndex]??0;
				$currentBankInterestExpense = $bankInterestExpenses[$currentMonthIndex]??0;
				if(!is_null($currentMonthIndex)){
					$formattedDirectFactoring['interest_revenue'][$currentMonthIndex] = isset($formattedDirectFactoring['interest_revenue'][$currentMonthIndex]) ? $formattedDirectFactoring['interest_revenue'][$currentMonthIndex] +  $currentInterestRevenue : $currentInterestRevenue;
					$formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex] = isset($formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex]) ? $formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex] +  $currentBankInterestExpense : $currentBankInterestExpense;
					$resultPerRevenueStreamType['direct-factoring'][$currentMonthIndex] = $formattedDirectFactoring['interest_revenue'][$currentMonthIndex];
					$salesRevenuePerTypes['direct-factoring'][$currentMonthIndex] = $resultPerRevenueStreamType['direct-factoring'][$currentMonthIndex];
					$currentDirectFactoringAtMonth = $salesRevenuePerTypes['direct-factoring'][$currentMonthIndex];
					$tableDataFormatted[0]['sub_items']['direct-factoring']['data'][$currentMonthIndex] = $currentDirectFactoringAtMonth ;
					$salesRevenuePerTypes['total_revenue'][$currentMonthIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentMonthIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentMonthIndex] + $currentDirectFactoringAtMonth : $currentDirectFactoringAtMonth;
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
				
			//	$currentMonthIndex = $monthsWithItsYear[$currentMonthIndex]??null;
				
				// $currentYearAsString = $yearIndexWithYear[$currentMonthIndex] ?? null ;
				if(!is_null($currentMonthIndex)){
					if($isPortfolio){
						// test function
						$salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex] =  isset($salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex]) ? $salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex] + $interestAmount : $interestAmount;
						$salesRevenuePerTypes['total_revenue'][$currentMonthIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentMonthIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentMonthIndex] + $interestAmount : $interestAmount;
						$tableDataFormatted[0]['main_items']['sales-revenue']['data'][$currentMonthIndex]  = $salesRevenuePerTypes['total_revenue'][$currentMonthIndex];
						$previousRecord = $tableDataFormatted[0]['main_items']['sales-revenue']['data'][$currentMonthIndex-1] ?? 0;
						$currentValue = $tableDataFormatted[0]['main_items']['sales-revenue']['data'][$currentMonthIndex] ;
						$tableDataFormatted[0]['main_items']['growth-rate']['data'][$currentMonthIndex] =  $previousRecord ?  ($currentValue - $previousRecord) / $previousRecord * 100 : 0; 
						$tableDataFormatted[0]['sub_items'][$revenueStreamType]['data'][$currentMonthIndex] = $salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex];
						$resultPerRevenueStreamType[$revenueStreamType][$currentMonthIndex] = isset($resultPerRevenueStreamType[$revenueStreamType][$currentMonthIndex]) ? $resultPerRevenueStreamType[$revenueStreamType][$currentMonthIndex] + $interestAmount : $interestAmount;
					//		 $resultPerRevenueStreamType[$revenueStreamType]['total'] = isset($resultPerRevenueStreamType[$revenueStreamType]['total']) ? $resultPerRevenueStreamType[$revenueStreamType]['total'] +  $interestAmount : $interestAmount;
							 
									
							$formattedResult['sales_revenue'][$currentMonthIndex] = isset($formattedResult['sales_revenue'][$currentMonthIndex]) ? $formattedResult['sales_revenue'][$currentMonthIndex] + $interestAmount : $interestAmount ;
	
							$currentDirectFactoringInterestRevenue  =$formattedDirectFactoring['interest_revenue'][$currentMonthIndex] ?? 0 ;
							$formattedResult['sales_revenue'][$currentMonthIndex] = $formattedResult['sales_revenue'][$currentMonthIndex] + $currentDirectFactoringInterestRevenue ;
							$currentSalesRevenue = $formattedResult['sales_revenue'][$currentMonthIndex] ;
							$previousSalesRevenue = $formattedResult['sales_revenue'][$currentMonthIndex-1] ?? 0 ;
							$formattedResult['growth_rate'][$currentMonthIndex] = $previousSalesRevenue ? (($currentSalesRevenue / $previousSalesRevenue)-1)*100 : 0 ;
						}else{
							$formattedResult['interest_cogs'][$currentMonthIndex] = isset($formattedResult['interest_cogs'][$currentMonthIndex]) ? $formattedResult['interest_cogs'][$currentMonthIndex] + $interestAmount : $interestAmount ;
							$currentDirectFactoringBankInterestExpense = $formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex]??0;
							$formattedResult['interest_cogs'][$currentMonthIndex] = $formattedResult['interest_cogs'][$currentMonthIndex] + $currentDirectFactoringBankInterestExpense;
						
							
						}
					}
				}
			
		}
	
		$salaryExpenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('departments')
		->join('positions','positions.department_id','=','departments.id')
		->selectRaw('expense_type,salary_expenses,expense_type')->where('type','manpower')->where('departments.company_id',$company->id)->get() ;
		
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
			$salaryExpensePayload = $salaryExpensePayload ? $salaryExpensePayload : [];
			foreach($monthsWithItsYear as $monthIndex => $yearIndex){
				
				$currentSalaryExpense = $salaryExpensePayload[$monthIndex]??[];
				$salaryExpensesForCategory[$expenseCategory][$monthIndex] = isset($salaryExpensesForCategory[$expenseCategory][$monthIndex]) ?  $salaryExpensesForCategory[$expenseCategory][$monthIndex] + $currentSalaryExpense : $currentSalaryExpense;
			}
		}
		
		foreach($expenses as $expense){
		
			$name = $expense->name;
			$relationName = $expense->relation_name;
			$expenseCategory = $expense->expense_category;
			$currentOrderIndex = $orderIndexPerExpenseCategory[$expenseCategory];
			$tableDataFormatted[$currentOrderIndex]['main_items'][$expenseCategory]['options']['title'] =$expenseMainTitlesMapping[$expenseCategory] ;
			
			$tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['options']['title'] =$name ;
			$currentColumnName = $columnPerTypes[$relationName]??null;
			if(is_null($currentColumnName)){
				continue;
			}
			$monthlyExpenses = (array)json_decode($expense->{$currentColumnName});
			foreach($yearWithItsIndexes as $yearIndex => $monthIndexWithActive){
				foreach($monthIndexWithActive as $monthIndex=> $isActiveIndex){
					
				
					$currentMonthInterestCost = 0 ;
				$currentMonthManpowerTotal = 0 ;
				if($expenseCategory == 'cost-of-service' && !isset($formattedExpenses[$expenseCategory]['Interest Cost'][$monthIndex])){
					$formattedExpenses[$expenseCategory]['Interest Cost'][$monthIndex]  = $formattedResult['interest_cogs'][$monthIndex]??0 ;
					$currentMonthInterestCost = $formattedExpenses[$expenseCategory]['Interest Cost'][$monthIndex];
					$tableDataFormatted[$currentOrderIndex]['sub_items']['Interest Cost']['data'][$monthIndex] =$currentMonthInterestCost ;
				}
				if(!isset($formattedExpenses[$expenseCategory]['Manpower Salaries'][$monthIndex])){
					$formattedExpenses[$expenseCategory]['Manpower Salaries'][$monthIndex] = $salaryExpensesForCategory[$expenseCategory][$monthIndex] ?? 0;
					$currentMonthManpowerTotal = $formattedExpenses[$expenseCategory]['Manpower Salaries'][$monthIndex];
					$tableDataFormatted[$currentOrderIndex]['sub_items']['Manpower Salaries']['data'][$monthIndex] =$currentMonthManpowerTotal ;
				}
			//	$currentExpenseItemTotalPerYear = 0 ;
				
					// $currentExpenseItemTotalPerYear +=  ;
				$currentMonthlyExpenseValue = $monthlyExpenses[$monthIndex]??0 ; 
				$formattedExpenses[$expenseCategory][$name][$monthIndex] = $currentMonthlyExpenseValue;
			
				$currentMonthTotal = $currentMonthlyExpenseValue + $currentMonthInterestCost +$currentMonthManpowerTotal;
				$formattedExpenses[$expenseCategory]['total'][$monthIndex] = isset($formattedExpenses[$expenseCategory]['total'][$monthIndex]) ? $formattedExpenses[$expenseCategory]['total'][$monthIndex] + $currentMonthTotal:$currentMonthTotal    ; 
				
				$currentTotalRevenueAtMonthIndex = $formattedResult['sales_revenue'][$monthIndex]??0;
				$tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['data'][$monthIndex] =$currentMonthlyExpenseValue ;
				$currentMainItemTotalAtYearIndex = $formattedExpenses[$expenseCategory]['total'][$monthIndex];
				$tableDataFormatted[$currentOrderIndex]['main_items'][$expenseCategory]['data'][$monthIndex] = $currentMainItemTotalAtYearIndex;
				$tableDataFormatted[$currentOrderIndex]['main_items']['% Of Revenue']['data'][$monthIndex] = $currentTotalRevenueAtMonthIndex ? $currentMainItemTotalAtYearIndex / $currentTotalRevenueAtMonthIndex *100 : 0 ;
				
				
				
			}
				
			}
		
			
		}
		foreach($yearWithItsIndexes as $yearIndex => $monthIndexWithActive){
			foreach($monthIndexWithActive as $monthIndex => $isActiveIndex){
				$currentMonthAsString = $dateIndexWithDate[$monthIndex] ;
			$currentSalesRevenue = $formattedResult['sales_revenue'][$monthIndex]??0;
			$resultPerRevenueStreamType['all'][$currentMonthAsString] = $currentSalesRevenue;
			$costOfServiceAtYearIndex = $formattedExpenses['cost-of-service']['total'][$monthIndex]??0;
			$formattedResult['gross_profit'][$monthIndex] = $currentSalesRevenue - $costOfServiceAtYearIndex;
			$currentGrossProfitAtMonthIndex = $formattedResult['gross_profit'][$monthIndex] ?? 0;
			$formattedResult['gross_profit_percentage_of_sales'][$monthIndex] = $currentSalesRevenue ? $currentGrossProfitAtMonthIndex / $currentSalesRevenue *100 : 0 ;
			$tableDataFormatted[$grossProfitOrderIndex]['main_items']['gross-profit']['data'][$monthIndex] = $currentGrossProfitAtMonthIndex ;
			$tableDataFormatted[$grossProfitOrderIndex]['main_items']['% Of Revenue']['data'][$monthIndex] = $currentGrossProfitAtMonthIndex ;
			$currentOPEXExpense =$formattedExpenses['other-operation-expense']['total'][$monthIndex]??0; 
			$currentMarketingExpense =$formattedExpenses['marketing-expense']['total'][$monthIndex]??0; 
			$currentSalesExpense =$formattedExpenses['sales-expense']['total'][$monthIndex]??0; 
			$currentGeneralExpense =$formattedExpenses['general-expense']['total'][$monthIndex]??0; 
			$currentDepreciationExpense =$formattedExpenses['depreciation-expense']['total'][$monthIndex]??0; 
			$currentEbitdaAtYearIndex = $currentSalesRevenue  - $costOfServiceAtYearIndex - $currentOPEXExpense - $currentMarketingExpense - $currentSalesExpense-$currentGeneralExpense+$currentDepreciationExpense;
			$formattedResult['ebitda'][$monthIndex] = $currentEbitdaAtYearIndex;
			$formattedResult['ebitda_percentage_of_sales'][$monthIndex] =$currentSalesRevenue ?  $currentEbitdaAtYearIndex / $currentSalesRevenue *100 :0;
			
			$tableDataFormatted[$ebitdaOrderIndex]['main_items']['ebitda']['data'][$monthIndex] = $currentEbitdaAtYearIndex ;
			$tableDataFormatted[$ebitdaOrderIndex]['main_items']['% Of Revenue']['data'][$monthIndex] = $formattedResult['ebitda_percentage_of_sales'][$monthIndex] ;
			
			$currentEbitAtYearIndex = $currentEbitdaAtYearIndex -  $currentDepreciationExpense;
			$formattedResult['ebit'][$monthIndex] = $currentEbitAtYearIndex;
			$formattedResult['ebit_percentage_of_sales'][$monthIndex] =$currentSalesRevenue ?  $currentEbitAtYearIndex / $currentSalesRevenue *100 :0;
			
			$tableDataFormatted[$ebitOrderIndex]['main_items']['ebit']['data'][$monthIndex] = $currentEbitdaAtYearIndex ;
			$tableDataFormatted[$ebitOrderIndex]['main_items']['% Of Revenue']['data'][$monthIndex] = $formattedResult['ebit_percentage_of_sales'][$monthIndex] ;
			
			
			$currentFinanceInterestExpense = $formattedExpenses['financial-interest-expense']['total'][$monthIndex]??0;
			$currentEbtAtYearIndex = $currentEbitAtYearIndex - $currentFinanceInterestExpense ;
			$formattedResult['ebt'][$monthIndex] = $currentEbtAtYearIndex;
			$formattedResult['ebt_percentage_of_sales'][$monthIndex] =$currentSalesRevenue ?  $currentEbtAtYearIndex / $currentSalesRevenue *100 :0;
			
			$tableDataFormatted[$ebtOrderIndex]['main_items']['ebt']['data'][$monthIndex] = $currentEbtAtYearIndex ;
			$tableDataFormatted[$ebtOrderIndex]['main_items']['% Of Revenue']['data'][$monthIndex] = $formattedResult['ebt_percentage_of_sales'][$monthIndex] ;
			
			
			$formattedResult['net_profit'][$monthIndex] = $currentEbtAtYearIndex <0 ? $currentEbtAtYearIndex :$currentEbtAtYearIndex * (1-$corporateTaxes)  ;  
			$formattedResult['net_profit_percentage_of_sales'][$monthIndex] = $currentSalesRevenue ? $formattedResult['net_profit'][$monthIndex] / $currentSalesRevenue  *100 :0 ;  
			
			$tableDataFormatted[$netProfitOrderIndex]['main_items']['net-profit']['data'][$monthIndex] = $currentEbitdaAtYearIndex ;
			$tableDataFormatted[$netProfitOrderIndex]['main_items']['% Of Revenue']['data'][$monthIndex] = $formattedResult['net_profit_percentage_of_sales'][$monthIndex] ;
			
			
			}
			
			
		}
		$studyMonthsForViews=$study->getStudyDurationPerYearFromIndexesForView();
		$tableDataFormatted = HArr::addTotalMonthsPerYear($tableDataFormatted,$financialYearsEndMonths);
		ksort($tableDataFormatted);
		
        return view('non_banking_services.income-statement.forecast', [
			'company'=>$company,
			'studyMonthsForViews'=>$studyMonthsForViews,
			'title'=>__('Forecasted Income Statement'),
			'tableTitle'=>__('Forecasted Income Statement'),
			'createRoute'=>route('create.financial.planning.study',['company'=>$company->id]),
			'studyMonths'=>$study->getStudyDurationPerYearFromIndexes(),
			'study'=>$study,
			'salesRevenuePerTypes'=>$salesRevenuePerTypes,
			'tableDataFormatted'=>$tableDataFormatted,
			// 'salaryExpensePerTypeAndExpenseTypes'=>$salaryExpensePerTypeAndExpenseTypes,
			'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber(),
			'monthsWithItsYear'=>$monthsWithItsYear,
			'defaultClasses'=>$defaultClasses
		]);
		
		
		
	}
	protected function getViewVars(Company $company , Study $model = null):array 
	{
		$actionRoute=isset($model) ? route('update.study',[$company->id , $model->id]) : route('store.financial.planning.study',['company'=>$company->id]);
		return [
			'company'=>$company,
			'title'=>$company->getName().' ' . __(' Financial Plan'),
			'model'=>$model,
			'actionRoute'=>$actionRoute,
			'navigators' => [],
		];
	}
	public function create(Company $company , Request $request){
		return view('financial_planning.study.form', $this->getViewVars($company));
	}
	public function store(Company $company , Request $request , Study $study = null)
	{
		$request->merge([
			'study_start_date'=>Carbon::make($request->get('study_start_date'))->format('Y-m-d'),
			'study_end_date'=>Carbon::make($request->get('study_end_date'))->format('Y-m-d'),
			'operation_start_date'=>Carbon::make($request->get('operation_start_date'))->format('Y-m-d'),
			// 'has_leasing'=>$request->boolean('has_leasing'),
			// 'has_direct_factoring'=>$request->boolean('has_direct_factoring'),
			// 'has_reverse_factoring'=>$request->boolean('has_reverse_factoring'),
			// 'has_ijara_mortgage'=>$request->boolean('has_ijara_mortgage'),
			// 'has_portfolio_mortgage'=>$request->boolean('has_portfolio_mortgage'),
			// 'has_micro_finance'=>$request->boolean('has_micro_finance'),
			// 'has_securitization'=>$request->boolean('has_securitization'),
			// 'has_consumer_finance'=>$request->boolean('has_consumer_finance'),
			
		]);
		$data = $request->except(['_token']) ;
		$model = null ;
		if(is_null($study)){
			$model = Study::create($data);
		}else{
			$study->update($data);
			$model = $study;
		}

		/**
		 * @var Study $model
		 */
		$datesAsStringAndIndex = $model->getDatesAsStringAndIndex();
		$studyDates = $model->getStudyDates() ;
		$datesAndIndexesHelpers = $model->datesAndIndexesHelpers($studyDates);
		$datesIndexWithYearIndex=$datesAndIndexesHelpers['datesIndexWithYearIndex']; 
		$yearIndexWithYear=$datesAndIndexesHelpers['yearIndexWithYear']; 
		$dateIndexWithDate=$datesAndIndexesHelpers['dateIndexWithDate']; 
		$dateWithMonthNumber=$datesAndIndexesHelpers['dateWithMonthNumber']; 
		$model->updateStudyAndOperationDates($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber);
		return response()->json([
			'redirectTo'=>route('create.general.assumption',['company'=>$company->id,'study'=>$model->id])
		]);
	}
	public function edit(Company $company , Request $request,Study $study){
		return view('financial_planning.study.form', $this->getViewVars($company,$study));
	}
	public function update(Request $request , Company $company,Study $study)
	{
		return $this->store($company,$request,$study);
	}
	public function destroy(Request $request , Company $company,Study $study)
	{
		$study->delete();
		return redirect()->back()->with('success',__('Study Has Been Deleted Successfully'));
	}
}
