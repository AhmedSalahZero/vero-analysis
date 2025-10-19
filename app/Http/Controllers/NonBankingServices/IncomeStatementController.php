<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\EclAndNewPortfolioFundingRate;
use App\Models\NonBankingService\Manpower;
use App\Models\NonBankingService\Study;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeStatementController extends Controller
{
    public function index(Company $company, Request $request, Study $study)
    {
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
        $loanSchedulePayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->selectRaw('portfolio_loan_type,revenue_stream_type,interestAmount')->where('study_id', $study->id)->get()->toArray();
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
         //   'depreciation'=>7,
            'ebitda'=>7,
            'ecl'=>8,
            'ebit'=>9,
            'financial-expense'=>10,
            'ebt'=>11,
            'corporate-taxes'=>12,
            'net-profit'=>13
        ];
        //	$depreciationOrderIndex = $orderIndexPerExpenseCategory['depreciation'] ;
        $financialYearsEndMonths = $study->getFinancialYearsEndMonths();
        $grossProfitOrderIndex = $orderIndexPerExpenseCategory['gross-profit'];
        $ebitdaOrderIndex = $orderIndexPerExpenseCategory['ebitda'];
        $eclAndDepreciationOrderIndex = $orderIndexPerExpenseCategory['ecl'];
        $ebitOrderIndex = $orderIndexPerExpenseCategory['ebit'];
        $ebtOrderIndex = $orderIndexPerExpenseCategory['ebt'];
        $netProfitOrderIndex = $orderIndexPerExpenseCategory['net-profit'];
        $corporateTaxesOrderIndex = $orderIndexPerExpenseCategory['corporate-taxes'];
        $financialExpenseOrderIndex = $orderIndexPerExpenseCategory['financial-expense'];
        
        $tableDataFormatted[0]['main_items']['sales-revenue']['options'] = array_merge([
            'title'=>__('Sales Revenue')
        ], $defaultNumericInputClasses);
        if ($study->hasLeasing()) {
            $tableDataFormatted[0]['main_items']['growth-rate']['options'] = array_merge($defaultPercentageInputClasses, ['title'=>__('Growth Rate %')]);
            $tableDataFormatted[0]['sub_items']['leasing']['options'] =array_merge([
                'title'=>__('Leasing'),
            ], $defaultNumericInputClasses);
        }
        if ($study->hasDirectFactoring()) {
            $tableDataFormatted[0]['sub_items']['direct-factoring']['options'] =array_merge([
                'title'=>__('Direct Factoring'),
            ], $defaultNumericInputClasses);
        }
        
        if ($study->hasIjaraMortgage()) {
            $tableDataFormatted[0]['sub_items']['ijara']['options'] =array_merge([
                'title'=>__('Ijara Mortgage'),
            ], $defaultNumericInputClasses);
        }
        if ($study->hasPortfolioMortgage()) {
            $tableDataFormatted[0]['sub_items'][Study::PORTFOLIO_MORTGAGE]['options'] =array_merge([
                'title'=>__('Portfolio Mortgage'),
            ], $defaultNumericInputClasses);
        }
        if ($study->hasReverseFactoring()) {
            $tableDataFormatted[0]['sub_items']['reverse-factoring']['options'] =array_merge([
                'title'=>__('Reverse Factoring'),
            ], $defaultNumericInputClasses);
        }
        
        if ($study->hasMicroFinance()) {
            $tableDataFormatted[0]['sub_items'][Study::MiCROFINANCE]['options'] =array_merge([
                'title'=>__('Microfinance'),
            ], $defaultNumericInputClasses);
        }
        if ($study->hasConsumerFinance()) {
            $tableDataFormatted[0]['sub_items'][Study::CONSUMER_FINANCE]['options'] =array_merge([
                'title'=>__('Consumer Finance'),
            ], $defaultNumericInputClasses);
        }
        if ($study->hasSecuritization()) {
            $tableDataFormatted[0]['sub_items'][Study::SECURITIZATION]['options'] =array_merge([
                'title'=>__('Securitization'),
            ], $defaultNumericInputClasses);
        }
        
        
        // $tableDataFormatted['cost-of-service']['main_items']['data'] = [];
        $tableDataFormatted[1]['main_items']['cost-of-service']['options']['title'] = __('Cost Of Service');
        $tableDataFormatted[1]['sub_items']['Interest Cost']['options']['title'] = __('Interest Cost');
        $tableDataFormatted[1]['sub_items']['Manpower Salaries']['options']['title'] = __('Manpower Salaries');

        
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['gross-profit']['options']['title'] = __('Gross Profit');
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        
        $otherOperationExpenseOrder = $orderIndexPerExpenseCategory['other-operation-expense'];

        
        $marketingExpenseOrder = $orderIndexPerExpenseCategory['marketing-expense'];
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['marketing-expense']['options']['title'] = __('Market Expense');
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        
        $salesExpenseOrder = $orderIndexPerExpenseCategory['sales-expense'];
        $tableDataFormatted[$salesExpenseOrder]['main_items']['sales-expense']['options']['title'] = __('Sales Expense');
        $tableDataFormatted[$salesExpenseOrder]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        
        
        $generalExpenseOrder = $orderIndexPerExpenseCategory['general-expense'];
        $tableDataFormatted[$generalExpenseOrder]['main_items']['general-expense']['options']['title'] = __('General Expense');
        $tableDataFormatted[$generalExpenseOrder]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        
        $depreciationKey ='total-depreciation';
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['ebitda']['options']['title'] = __('EBITDA');
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $eclAndDepreciationKey = 'ecl-and-depreciation-expenses';
        // $tableDataFormatted[$eclAndDepreciationOrderIndex]['main_items'][$eclAndDepreciationKey]['options']['title'] = __('ECL & Depreciation Cost');
        //   $tableDataFormatted[$depreciationOrderIndex]['main_items'][$depreciationKey]['options']['title'] = __('Depreciation Expenses');
        $studyMonthsForViews = $study->getStudyDates();
        $studyMonthsForViews = array_slice($studyMonthsForViews, 0, $study->getViewStudyEndDateAsIndex()+1);
        $yearWithItsMonths=$study->getYearIndexWithItsMonths();
        $studyDates = array_keys($study->getStudyDates()) ;
        $sumKeys = $studyDates;
        
        
        // 	$totalDepreciation = Harr::calculateTotalFromSubItems($tableDataFormatted[$depreciationOrderIndex]['sub_items']??[]) ;
        // 	$tableDataFormatted[$depreciationOrderIndex]['main_items'][$depreciationKey]['data'] = $totalDepreciation;
        //    $tableDataFormatted[$depreciationOrderIndex]['main_items'][$depreciationKey]['year_total'] =$totalDepreciationPerYears =  HArr::getPerYearIndexForCashAndBank($totalDepreciation, $yearWithItsMonths);
        
               
        // 		$currentMainTotal = Harr::calculateTotalFromSubItems($tableDataFormatted[$eclOrderIndex]['sub_items']??[]) ;
        // 	$tableDataFormatted[$eclOrderIndex]['main_items']['ecl']['data'] = $currentMainTotal;
        //    $tableDataFormatted[$eclOrderIndex]['main_items']['ecl']['year_total'] =$totalEclPerYears =  HArr::getPerYearIndexForCashAndBank($currentMainTotal, $yearWithItsMonths);
        // $tableDataFormatted[$eclOrderIndex]['sub_items'][__('ECL Expense')]['data'] = [];
        //    $tableDataFormatted[$eclOrderIndex]['sub_items'][__('Depreciation Expense')]['data'] = [];
        
        
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
        ->where('study_id', $study->id)
        ->selectRaw('interest_revenue,bank_interest_expense')->get()->toArray();
    
        $formattedDirectFactoring = [];
        foreach ($directFactoringBreakdown as $currentDirectFactoringBreakdown) {
            $interestRevenues= (array)json_decode($currentDirectFactoringBreakdown->interest_revenue);
            $bankInterestExpenses= (array)json_decode($currentDirectFactoringBreakdown->bank_interest_expense);
            foreach ($monthsWithItsYear as $currentMonthIndex => $currentYearIndex) {
                $currentMonthAsString = $dateIndexWithDate[$currentMonthIndex];
                $currentInterestRevenue  = $interestRevenues[$currentMonthIndex]??0;
                $currentBankInterestExpense = $bankInterestExpenses[$currentMonthIndex]??0;
                if (!is_null($currentMonthIndex)) {
                    $formattedDirectFactoring['interest_revenue'][$currentMonthIndex] = isset($formattedDirectFactoring['interest_revenue'][$currentMonthIndex]) ? $formattedDirectFactoring['interest_revenue'][$currentMonthIndex] +  $currentInterestRevenue : $currentInterestRevenue;
                    $formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex] = isset($formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex]) ? $formattedDirectFactoring['bank_interest_expense'][$currentMonthIndex] +  $currentBankInterestExpense : $currentBankInterestExpense;
                    $resultPerRevenueStreamType['direct-factoring'][$currentMonthIndex] = $formattedDirectFactoring['interest_revenue'][$currentMonthIndex];
                    $salesRevenuePerTypes['direct-factoring'][$currentMonthIndex] = $resultPerRevenueStreamType['direct-factoring'][$currentMonthIndex];
                    $currentDirectFactoringAtMonth = $salesRevenuePerTypes['direct-factoring'][$currentMonthIndex];
                    $tableDataFormatted[0]['sub_items']['direct-factoring']['data'][$currentMonthIndex] = $currentDirectFactoringAtMonth ;
                    
                    //        $salesRevenuePerTypes['total_revenue'][$currentMonthIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentMonthIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentMonthIndex] + $currentDirectFactoringAtMonth : $currentDirectFactoringAtMonth;
                }
            }
        }
        
        
        foreach ($loanSchedulePayments as $loanSchedulePaymentAsStdClass) {
            $portfolioLoanType = $loanSchedulePaymentAsStdClass->portfolio_loan_type;
            $isPortfolio = $portfolioLoanType == 'portfolio';
            $revenueStreamType = $loanSchedulePaymentAsStdClass->revenue_stream_type;
            $interestAmounts = json_decode($loanSchedulePaymentAsStdClass->interestAmount);
            foreach ($interestAmounts as $currentMonthIndex => $interestAmount) {
                if (!is_null($currentMonthIndex)) {
                    if ($isPortfolio) {
                        $salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex] =  isset($salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex]) ? $salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex] + $interestAmount : $interestAmount;
                        $salesRevenuePerTypes['total_revenue'][$currentMonthIndex] =  isset($salesRevenuePerTypes['total_revenue'][$currentMonthIndex]) ? $salesRevenuePerTypes['total_revenue'][$currentMonthIndex] + $interestAmount : $interestAmount;
                        $tableDataFormatted[0]['sub_items'][$revenueStreamType]['data'][$currentMonthIndex] = $salesRevenuePerTypes[$revenueStreamType][$currentMonthIndex];
                    } else {
						
						$formattedResult['interest_cogs'][$currentMonthIndex] = isset($formattedResult['interest_cogs'][$currentMonthIndex]) ? $formattedResult['interest_cogs'][$currentMonthIndex] + $interestAmount : $interestAmount ;
                        // $formattedResult['interest_cogs'][$currentMonthIndex] = $formattedResult['interest_cogs'][$currentMonthIndex] ;
                        $formattedExpenses['cost-of-service']['Interest Cost'][$currentMonthIndex]  = $formattedResult['interest_cogs'][$currentMonthIndex]??0 ;
                        // $currentMonthInterestCost = ;
                        $tableDataFormatted[1]['sub_items']['Interest Cost']['data'][$currentMonthIndex] =$formattedExpenses['cost-of-service']['Interest Cost'][$currentMonthIndex] ;
						
                        // $tableDataFormatted[1]['sub_items']['Interest Cost']['data'][$currentMonthIndex] = isset($formattedResult['interest_cogs'][$currentMonthIndex]) ? $formattedResult['interest_cogs'][$currentMonthIndex] + $interestAmount : $interestAmount ;
					
                    }
                }
            }
            
        }
		// dd($tableDataFormatted[1]['sub_items']['Interest Cost']['data']);
		$interestCosts  = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('direct_factoring_breakdowns')->where('study_id',$study->id)->pluck('bank_interest_expense')->toArray();
		// $totalDirectFactoring = [];
		foreach($interestCosts as $interestCost){
			$interestCost = json_decode($interestCost,true);
			foreach($interestCost as $dateIndex => $value){
				// dd($tableDataFormatted[1]['sub_items']['Interest Cost']['data']);
				// $totalDirectFactoring [$dateIndex] = isset($totalDirectFactoring [$dateIndex]) ? $totalDirectFactoring [$dateIndex]+ $value : $value;
				$tableDataFormatted[1]['sub_items']['Interest Cost']['data'][$dateIndex] = isset($tableDataFormatted[1]['sub_items']['Interest Cost']['data'][$dateIndex]) ? $tableDataFormatted[1]['sub_items']['Interest Cost']['data'][$dateIndex] + $value : $value  ;
			}
		}
		// $tableDataFormatted[1]['sub_items']['Interest Cost']['data'] = HArr::sumAtDates([$tableDataFormatted[1]['sub_items']['Interest Cost']['data']??[] ,$totalDirectFactoring  ],$sumKeys);
		// dd($totalDirectFactoring);
                      
						
        $monthlyAdminFees = EclAndNewPortfolioFundingRate::where('study_id', $study->id)->get([
            'monthly_admin_fees_amounts'])->toArray();
        $monthAdminFees = array_column($monthlyAdminFees, 'monthly_admin_fees_amounts');
        $monthAdminFees = HArr::sumAtDates($monthAdminFees, $studyDates);
        
        $tableDataFormatted[0]['sub_items']['monthly-admin-fees']['data'] = $monthAdminFees;
        $tableDataFormatted[0]['sub_items']['monthly-admin-fees']['options']['title'] = __('Monthly Admin Fees');
        $tableDataFormatted[0]['sub_items']['monthly-admin-fees']['year_total'] = HArr::sumPerYearIndex($monthAdminFees, $yearWithItsMonths);
    
			
		
		
		
     
        foreach($tableDataFormatted[0]['sub_items']?? [] as $id => $subItemArr){
			$tableDataFormatted[0]['sub_items'][$id]['year_total'] =	HArr::sumPerYearIndex($subItemArr, $yearWithItsMonths);
		}
        
        $totalSalesRevenues = Harr::calculateTotalFromSubItems($tableDataFormatted[0]['sub_items']??[]) ;
        
        $yearWithItsMonths=$study->getYearIndexWithItsMonths();
               
               
        $tableDataFormatted[0]['main_items']['sales-revenue']['data'] = $totalSalesRevenues;
        $tableDataFormatted[0]['main_items']['sales-revenue']['year_total'] =$totalSalesRevenuesPerYears =  HArr::sumPerYearIndex($totalSalesRevenues, $yearWithItsMonths);
        $tableDataFormatted[0]['main_items']['growth-rate']['data'] = Harr::calculateGrowthRate($totalSalesRevenues);
        $tableDataFormatted[0]['main_items']['growth-rate']['year_total'] =$totalSalesRevenuesPerYears =  HArr::calculateGrowthRate($totalSalesRevenuesPerYears);
               
        
    
        
        $expenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('expenses')->join('expense_names', 'expense_names.id', '=', 'expenses.expense_name_id')->selectRaw('expenses.expense_category,expense_names.name as name,expenses.relation_name,expenses.monthly_repeating_amounts,expenses.expense_as_percentages,payload')->where('expenses.model_id', $study->id)->where('expenses.model_name', 'Study')->get()->toArray();
        $columnPerTypes = [
            'one_time_expense'=>'payload',
            'percentage_of_sales'=>'expense_as_percentages',
            'fixed_monthly_repeating_amount'=>'monthly_repeating_amounts',
            'cost_per_unit'=>'monthly_repeating_amounts',
            'expense_per_employee'=>'monthly_repeating_amounts',
        ];
        $salaryExpensesForCategories = Manpower::getSalaryExpensesPerCategory($monthsWithItsYear, $study->id, $company->id);
        foreach ($salaryExpensesForCategories as $manpowerCategory => $salaryExpensesForCategory) {
            foreach ($salaryExpensesForCategory as $monthIndex => $value) {
                $currentOrderIndex = $orderIndexPerExpenseCategory[$manpowerCategory];
                $currentValue = $salaryExpensesForCategories[$manpowerCategory][$monthIndex] ?? 0 ;
                $formattedExpenses[$manpowerCategory]['Manpower Salaries'][$monthIndex] = isset($formattedExpenses[$manpowerCategory]['Manpower Salaries'][$monthIndex]) ? $formattedExpenses[$manpowerCategory]['Manpower Salaries'][$monthIndex] +  $currentValue : $currentValue;
                $currentMonthManpowerTotal = $formattedExpenses[$manpowerCategory]['Manpower Salaries'][$monthIndex];
                $tableDataFormatted[$currentOrderIndex]['sub_items']['Manpower Salaries']['data'][$monthIndex] =$currentMonthManpowerTotal ;
            }
        }
        
        foreach ($expenses as $expense) {
        
            $name = $expense->name;
            $relationName = $expense->relation_name;
            $expenseCategory = $expense->expense_category;
            
            $currentOrderIndex = $orderIndexPerExpenseCategory[$expenseCategory];
            $tableDataFormatted[$currentOrderIndex]['main_items'][$expenseCategory]['options']['title'] =$expenseMainTitlesMapping[$expenseCategory] ;
            $tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['options']['title'] =$name ;
            $currentColumnName = $columnPerTypes[$relationName];
          
            
            $monthlyExpenses = (array)json_decode($expense->{$currentColumnName});
            foreach ($yearWithItsIndexes as $yearIndex => $monthIndexWithActive) {
                foreach ($monthIndexWithActive as $monthIndex=> $isActiveIndex) {
                    $currentMonthManpowerTotal = 0 ;
                    $monthlyExpenses = $relationName == 'one_time_expense' && isset($monthlyExpenses['monthly_one_time']) ? ($monthlyExpenses['monthly_one_time']) : $monthlyExpenses;
                    $currentMonthlyExpenseValue = $monthlyExpenses[$monthIndex]??0 ;
                    $tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['data'][$monthIndex] = isset($tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['data'][$monthIndex]) ? $tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['data'][$monthIndex] + $currentMonthlyExpenseValue:$currentMonthlyExpenseValue ;
                }
                
            }
   
        }

        $totalCostOfService = Harr::calculateTotalFromSubItems($tableDataFormatted[1]['sub_items']??[]) ;
        $tableDataFormatted[1]['main_items']['cost-of-service']['data'] = $totalCostOfService;
        $tableDataFormatted[1]['main_items']['cost-of-service']['year_total'] =$totalCostOfServicePerYear =  HArr::sumPerYearIndex($totalCostOfService, $yearWithItsMonths);
        $tableDataFormatted[1]['main_items']['% Of Revenue']['data'] = HArr::calculatePercentageOf($totalSalesRevenues, $totalCostOfService);
        $tableDataFormatted[1]['main_items']['% Of Revenue']['year_total'] =$totalCostOfServicePerYears =  HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $totalCostOfServicePerYear);
               
               

        $totalGrossProfit = HArr::subtractAtDates([$totalSalesRevenues,$totalCostOfService], $sumKeys) ;
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['gross-profit']['data'] =  $totalGrossProfit ;
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['gross-profit']['year_total'] = $grossProfitTotalPerYear = HArr::sumPerYearIndex($totalGrossProfit, $yearWithItsMonths);
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['gross-profit']['options']['title'] = __('Gross Profit');
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalGrossProfit) ;
        $tableDataFormatted[$grossProfitOrderIndex]['main_items']['% Of Revenue']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $grossProfitTotalPerYear);

        
        
        $eclExpenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('ecl_and_new_portfolio_funding_rates')->where('study_id', $study->id)->pluck('monthly_ecl_values')->toArray();
        $totalEclExpenses = [];
        $title = __('Ecl Expense')  ;
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items'][$title]['options'] =array_merge([
            'title'=>$title
        ], $defaultNumericInputClasses);
        foreach ($eclExpenses as $currentData) {
            $currentData = (array) json_decode($currentData);
            $totalEclExpenses  = HArr::sumAtDates([$totalEclExpenses,$currentData], $sumKeys);
        }
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items'][$title]['data'] = $totalEclExpenses;
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($totalEclExpenses, $yearWithItsMonths);
    
        $totalDepreciationExpenses = [];
        $fixedAssetDepreciations = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_assets')->where('study_id', $study->id)->pluck('total_monthly_depreciations')->toArray();
        $title = __('Depreciation Expense')  ;
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items'][$depreciationKey]['options'] =array_merge([
            'title'=>$title
        ], $defaultNumericInputClasses);
        foreach ($fixedAssetDepreciations as $revenueType => $currentData) {
            $currentData = json_decode($currentData, true);
            $totalDepreciationExpenses  = HArr::sumAtDates([$totalDepreciationExpenses,$currentData], $sumKeys);
        }
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items'][$depreciationKey]['data'] = $totalDepreciationExpenses;
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items'][$depreciationKey]['year_total'] = HArr::sumPerYearIndex($totalDepreciationExpenses, $yearWithItsMonths);
        $totalEclAndDepreciationExpenses = Harr::calculateTotalFromSubItems($tableDataFormatted[$eclAndDepreciationOrderIndex]['sub_items']??[]);
        
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['main_items'][$eclAndDepreciationKey]['data'] =  $totalEclAndDepreciationExpenses ;
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['main_items'][$eclAndDepreciationKey]['year_total'] = $totalEclAndDepreciationExpensesPerYear = HArr::sumPerYearIndex($totalEclAndDepreciationExpenses, $yearWithItsMonths);
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['main_items'][$eclAndDepreciationKey]['options']['title'] = __('ECL & Depreciation Cost');
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalEclAndDepreciationExpenses) ;
        $tableDataFormatted[$eclAndDepreciationOrderIndex]['main_items']['% Of Revenue']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $totalEclAndDepreciationExpensesPerYear);

        // sub items total per year
        $currentSubItems = $tableDataFormatted[$otherOperationExpenseOrder]['sub_items']??[];
        foreach ($currentSubItems as $subItemName => $subItemData) {
            $tableDataFormatted[$otherOperationExpenseOrder]['sub_items'][$subItemName]['year_total'] = HArr::sumPerYearIndex($subItemData['data']??[], $yearWithItsMonths);
        }
        // $tableDataFormatted[$currentOrderIndex]['sub_items'][$name]['year_total']
        $totalOtherOperatingExpenses = HArr::calculateTotalFromSubItems($currentSubItems) ;
        $tableDataFormatted[$otherOperationExpenseOrder]['main_items']['other-operation-expense']['data'] =  $totalOtherOperatingExpenses ;
        $tableDataFormatted[$otherOperationExpenseOrder]['main_items']['other-operation-expense']['year_total'] = $otherOperatingExpensesTotalPerYear = HArr::sumPerYearIndex($totalOtherOperatingExpenses, $yearWithItsMonths);
        $tableDataFormatted[$otherOperationExpenseOrder]['main_items']['other-operation-expense']['options']['title'] = __('Other Operation Expense');
        $tableDataFormatted[$otherOperationExpenseOrder]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalOtherOperatingExpenses) ;
        $tableDataFormatted[$otherOperationExpenseOrder]['main_items']['% Of Revenue']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $otherOperatingExpensesTotalPerYear);
        
        
        
        $currentSubItems = $tableDataFormatted[$marketingExpenseOrder]['sub_items']??[];
        foreach ($currentSubItems as $subItemName => $subItemData) {
            $tableDataFormatted[$marketingExpenseOrder]['sub_items'][$subItemName]['year_total'] = HArr::sumPerYearIndex($subItemData['data']??[], $yearWithItsMonths);
        }
        $totalMarketingExpenses = HArr::calculateTotalFromSubItems($tableDataFormatted[$marketingExpenseOrder]['sub_items']??[]) ;
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['marketing-expense']['data'] =  $totalMarketingExpenses ;
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['marketing-expense']['year_total'] = $totalMarketingExpensesPerYear = HArr::sumPerYearIndex($totalMarketingExpenses, $yearWithItsMonths);
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['marketing-expense']['options']['title'] = __('Marketing Expenses');
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalMarketingExpenses) ;
        $tableDataFormatted[$marketingExpenseOrder]['main_items']['% Of Revenue']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $totalMarketingExpensesPerYear);
        
        
        
        
        $currentSubItems = $tableDataFormatted[$salesExpenseOrder]['sub_items']??[];
        foreach ($currentSubItems as $subItemName => $subItemData) {
            $tableDataFormatted[$salesExpenseOrder]['sub_items'][$subItemName]['year_total'] = HArr::sumPerYearIndex($subItemData['data']??[], $yearWithItsMonths);
        }
        $totalSalesExpenses = HArr::calculateTotalFromSubItems($tableDataFormatted[$salesExpenseOrder]['sub_items']??[]) ;
        $tableDataFormatted[$salesExpenseOrder]['main_items']['sales-expense']['data'] =  $totalSalesExpenses ;
        $tableDataFormatted[$salesExpenseOrder]['main_items']['sales-expense']['year_total'] = $totalSalesExpensesPerYear = HArr::sumPerYearIndex($totalSalesExpenses, $yearWithItsMonths);
        $tableDataFormatted[$salesExpenseOrder]['main_items']['sales-expense']['options']['title'] = __('Sales Expense');
        $tableDataFormatted[$salesExpenseOrder]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalSalesExpenses) ;
        $tableDataFormatted[$salesExpenseOrder]['main_items']['% Of Revenue']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $totalSalesExpensesPerYear);
        
            
        
        
        $currentSubItems = $tableDataFormatted[$generalExpenseOrder]['sub_items']??[];
        foreach ($currentSubItems as $subItemName => $subItemData) {
            $tableDataFormatted[$generalExpenseOrder]['sub_items'][$subItemName]['year_total'] = HArr::sumPerYearIndex($subItemData['data']??[], $yearWithItsMonths);
        }
        $totalGeneralExpenses = HArr::calculateTotalFromSubItems($tableDataFormatted[$generalExpenseOrder]['sub_items']??[]) ;
        $tableDataFormatted[$generalExpenseOrder]['main_items']['general-expense']['data'] =  $totalGeneralExpenses ;
        $tableDataFormatted[$generalExpenseOrder]['main_items']['general-expense']['year_total'] = $totalGeneralExpensesPerYear = HArr::sumPerYearIndex($totalGeneralExpenses, $yearWithItsMonths);
        $tableDataFormatted[$generalExpenseOrder]['main_items']['general-expense']['options']['title'] = __('General Expense');
        $tableDataFormatted[$generalExpenseOrder]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalGeneralExpenses) ;
        $tableDataFormatted[$generalExpenseOrder]['main_items']['% Of Revenue']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $totalGeneralExpensesPerYear);
        $totalSGANDA = HArr::sumAtDates([$totalGeneralExpenses,$totalSalesExpenses,$totalMarketingExpenses], $sumKeys);
        
        /**
         * * Five Item
         */
          
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['ebitda']['options']['title'] = __('EBITDA');
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $fixedAssetAdminDepreciations = [];
        $fixedAssetOpeningBalancesAdminDepreciations = [];
        $fixedAssetOpeningBalancesAdminDepreciations = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_asset_opening_balances')->where('study_id', $study->id)->pluck('monthly_depreciation')->toArray();
        array_walk($fixedAssetOpeningBalancesAdminDepreciations, function (&$value) {
            $value = (array)json_decode($value);
        });
        $totalFixedAssetAdminDepreciation = HArr::sumAtDates(array_merge($fixedAssetAdminDepreciations, $fixedAssetOpeningBalancesAdminDepreciations), $sumKeys);
        $totalDepreciation = HArr::sumAtDates([$totalFixedAssetAdminDepreciation,$totalGrossProfit], $sumKeys);
        $editda = HArr::subtractAtDates([$totalDepreciation,$totalSGANDA], $sumKeys) ;
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['ebitda']['data'] = $editda;
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['ebitda']['year_total'] =$ebitdaTotalPerYear= HArr::sumPerYearIndex($editda, $yearWithItsMonths);
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['% Of Revenue']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $editda);
        $tableDataFormatted[$ebitdaOrderIndex]['main_items']['% Of Revenue']['year_total'] = $editdaRevenuePercentage = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $ebitdaTotalPerYear);
        /**
         * * End Five Item
         */
        
        
        /**
         * * Start Sixth Item
         */
        $tableDataFormatted[$ebitOrderIndex]['main_items']['ebit']['options']['title'] = __('EBIT');
        $ebit = HArr::subtractAtDates([$totalGrossProfit,$totalSGANDA,$totalEclAndDepreciationExpenses], $sumKeys) ;
        $tableDataFormatted[$ebitOrderIndex]['main_items']['ebit']['data'] = $ebit ;
        $tableDataFormatted[$ebitOrderIndex]['main_items']['ebit']['year_total'] =$ebitTotalPerYear= HArr::sumPerYearIndex($ebit, $yearWithItsMonths);
        $tableDataFormatted[$ebitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $tableDataFormatted[$ebitOrderIndex]['main_items']['% Of Revenue']['data'] = HArr::calculatePercentageOf($totalSalesRevenues, $ebit);
        $tableDataFormatted[$ebitOrderIndex]['main_items']['% Of Revenue']['year_total'] = $grossProfitRevenuePercentages =$editRevenuePercentage= HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $ebitTotalPerYear);
        /**
         * * End  Sixth Item
         */
        
        
        /**
        * * Start Seven Item
        */
        $tableDataFormatted[$financialExpenseOrderIndex]['main_items']['finance_exp']['options'] = array_merge([
            'title'=>__('Finance Expense')
        ], $defaultNumericInputClasses);
      
        $openingLoans = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('long_term_loan_opening_balances')->where('study_id', $study->id)->pluck('interests')->toArray();
        $openingLoansTotal=[];
        foreach ($openingLoans as $openingLoanInterest) {
            $openingLoansTotal= HArr::sumAtDates([(array)json_decode($openingLoanInterest),$openingLoansTotal], $sumKeys);
        }
        if (count($openingLoansTotal)) {
            $tableDataFormatted[$financialExpenseOrderIndex]['sub_items'][__('Opening Balance Loans Interests')]['data'] = $openingLoansTotal;
            $tableDataFormatted[$financialExpenseOrderIndex]['sub_items'][__('Opening Balance Loans Interests')]['year_total'] = HArr::sumPerYearIndex($openingLoansTotal, $yearWithItsMonths);
        }
        
        /**
         * ! end review
         */
        
        
        $totalFinanceExpense = HArr::sumAtDates(array_column($tableDataFormatted[$financialExpenseOrderIndex]['sub_items']??[], 'data'), $sumKeys);
        $tableDataFormatted[$financialExpenseOrderIndex]['main_items']['finance_exp']['data'] = $totalFinanceExpense;
        $tableDataFormatted[$financialExpenseOrderIndex]['main_items']['finance_exp']['year_total'] = $financeExpenseTotalPerYear = HArr::sumPerYearIndex($totalFinanceExpense, $yearWithItsMonths);
        
        $tableDataFormatted[$financialExpenseOrderIndex]['main_items']['revenues-percentage']['options'] = array_merge([
            'title'=>__('%/Revenues')
        ], $defaultPercentageInputClasses);
        
        $tableDataFormatted[$financialExpenseOrderIndex]['main_items']['revenues-percentage']['data'] =  HArr::calculatePercentageOf($totalSalesRevenues, $totalFinanceExpense) ;
        $tableDataFormatted[$financialExpenseOrderIndex]['main_items']['revenues-percentage']['year_total'] = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $financeExpenseTotalPerYear);
        /**
         * * End Seven Item
         */
        
        
        /**
         * * Start Eight Item
         */
        
        
        $ebt = HArr::subtractAtDates([$ebit,$totalFinanceExpense], $sumKeys);
        $tableDataFormatted[$ebtOrderIndex]['main_items']['ebt']['options']['title'] = __('EBT');
        $tableDataFormatted[$ebtOrderIndex]['main_items']['ebt']['data'] = $ebt;
        $tableDataFormatted[$ebtOrderIndex]['main_items']['ebt']['year_total'] =$ebtTotalPerYear = HArr::sumPerYearIndex($ebt, $yearWithItsMonths);
        $tableDataFormatted[$ebtOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $tableDataFormatted[$ebtOrderIndex]['main_items']['% Of Revenue']['data']=  HArr::calculatePercentageOf($totalSalesRevenues, $ebt);
        $tableDataFormatted[$ebtOrderIndex]['main_items']['% Of Revenue']['year_total'] = $ebtRevenuePercentagePerYear= HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $ebtTotalPerYear);
           
        
        /**
         * * End Eight Item
         */
        
        
        /**
        * * Start Nine Item
        */
        $corporateTaxesRate = $study->corporate_taxes_rate/100;
        $annuallyCorporateTaxes =  HArr::MultiplyWithNumberIfPositive($ebt, $corporateTaxesRate);
        $annuallyCorporateTaxes = HArr::sumPerYearIndex($annuallyCorporateTaxes, $yearWithItsMonths);
        $tableDataFormatted[$corporateTaxesOrderIndex]['main_items']['corporate-taxes']['options']['title'] = __('Corporate Taxes');
        $tableDataFormatted[$corporateTaxesOrderIndex]['main_items']['corporate-taxes']['data'] = $annuallyCorporateTaxes;
        $tableDataFormatted[$corporateTaxesOrderIndex]['main_items']['corporate-taxes']['year_total'] = $annuallyCorporateTaxes;
        $tableDataFormatted[$corporateTaxesOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $tableDataFormatted[$corporateTaxesOrderIndex]['main_items']['% Of Revenue']['data']=  [];
        $tableDataFormatted[$corporateTaxesOrderIndex]['main_items']['% Of Revenue']['year_total'] = $corporateTaxesRevenuePercentage=HArr::calculatePercentageOf($totalSalesExpensesPerYear, $annuallyCorporateTaxes);
        
        $totalProductsWithholdAmounts = [];
        
        $dateIndexWithDate = $study->getDateIndexWithDate();
        $calculatedCorporateTaxesPerYear = HArr::sumPerYearIndex($annuallyCorporateTaxes, $yearWithItsMonths) ;
        foreach ($calculatedCorporateTaxesPerYear as $dateIndex => &$value) {
            if ($value < 0) {
                $value =0 ;
            }
        }
        $corporateTaxesPayable = $study->getCorporateTaxesPayable();
        $studyStartDateAsMonthNumber = array_values($study->getDateWithMonthNumber())[0];
		$dates = $study->getStudyDates();
		
        $corporateTaxesStatement  = Study::calculateCorporateTaxesStatement($dates,$totalProductsWithholdAmounts, $calculatedCorporateTaxesPerYear, $corporateTaxesPayable, $dateIndexWithDate, $studyStartDateAsMonthNumber);

        
      
    
        /**
         * * End Nine Item
         */
        
        /**
         * * Start  Sixth Item
         */
        
        $annuallyNetProfit = HArr::subtractAtDates([$ebt,$annuallyCorporateTaxes], $sumKeys);
        $netProfit = $annuallyNetProfit;
        $tableDataFormatted[$netProfitOrderIndex]['main_items']['net-profit']['options']['title'] = __('Net Profit');
        $tableDataFormatted[$netProfitOrderIndex]['main_items']['net-profit']['data'] = $netProfit;
        $tableDataFormatted[$netProfitOrderIndex]['main_items']['net-profit']['year_total'] = $netProfitTotalPerYear = HArr::sumPerYearIndex($annuallyNetProfit, $yearWithItsMonths);
        $tableDataFormatted[$netProfitOrderIndex]['main_items']['% Of Revenue']['options']['title'] = __('% Of Revenue');
        $tableDataFormatted[$netProfitOrderIndex]['main_items']['% Of Revenue']['data'] = HArr::calculatePercentageOf($totalSalesRevenues, $netProfit);
        $tableDataFormatted[$netProfitOrderIndex]['main_items']['% Of Revenue']['year_total'] = $netProfitRevenuePercentage = HArr::calculatePercentageOf($totalSalesRevenuesPerYears, $netProfitTotalPerYear);
        
        $retainedEarningOpening = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('equity_opening_balances')->where('study_id', $study->id)->first();
        $retainedEarningOpening = $retainedEarningOpening ? $retainedEarningOpening->retained_earnings : 0;
        // $retainedEarning = HArr::calculateRetainEarning($retainedEarningOpening,$ebt);
        $retainedEarning = HArr::calculateRetainEarning($retainedEarningOpening, $netProfit);
        $statementData = [
            'monthly_corporate_taxes_statements'=>$corporateTaxesStatement,
            'monthly_net_profit'=>$netProfit,
             'accumulated_retained_earnings'=>$retainedEarning,
            'study_id'=>$study->id
        ];
        $study->incomeStatement ?  $study->incomeStatement->update($statementData) : $study->incomeStatement()->create($statementData);
        $studyMonthsForViews=$study->getStudyDurationPerYearFromIndexesForView();
        ksort($tableDataFormatted);
        return view('non_banking_services.income-statement.cash-flow', [
            'company'=>$company,
            'studyMonthsForViews'=>$studyMonthsForViews,
            'title'=>__('Forecasted Income Statement'),
            'tableTitle'=>__('Forecasted Income Statement'),
            'createRoute'=>route('create.financial.planning.study', ['company'=>$company->id]),
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
    protected function getViewVars(Company $company, Study $model = null):array
    {
        $actionRoute=isset($model) ? route('update.study', [$company->id , $model->id]) : route('store.financial.planning.study', ['company'=>$company->id]);
        return [
            'company'=>$company,
            'title'=>$company->getName().' ' . __(' Financial Plan'),
            'model'=>$model,
            'actionRoute'=>$actionRoute,
            'navigators' => [],
        ];
    }
    public function create(Company $company, Request $request)
    {
        return view('financial_planning.study.form', $this->getViewVars($company));
    }
    public function store(Company $company, Request $request, Study $study = null)
    {
        $request->merge([
            'study_start_date'=>Carbon::make($request->get('study_start_date'))->format('Y-m-d'),
            'study_end_date'=>Carbon::make($request->get('study_end_date'))->format('Y-m-d'),
            'operation_start_date'=>Carbon::make($request->get('operation_start_date'))->format('Y-m-d'),

            
        ]);
        $data = $request->except(['_token']) ;
        $model = null ;
        if (is_null($study)) {
            $model = Study::create($data);
        } else {
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
        $model->updateStudyAndOperationDates($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber);
        return response()->json([
            'redirectTo'=>route('create.general.assumption', ['company'=>$company->id,'study'=>$model->id])
        ]);
    }
    public function edit(Company $company, Request $request, Study $study)
    {
        return view('financial_planning.study.form', $this->getViewVars($company, $study));
    }
    public function update(Request $request, Company $company, Study $study)
    {
        return $this->store($company, $request, $study);
    }
    public function destroy(Request $request, Company $company, Study $study)
    {
        $study->delete();
        return redirect()->back()->with('success', __('Study Has Been Deleted Successfully'));
    }
}
