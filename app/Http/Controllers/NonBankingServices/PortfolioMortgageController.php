<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StorePortfolioMortgageRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\PortfolioMortgageRevenueProjectionByCategory;
use App\Models\NonBankingService\PortfolioMortgageRevenueStreamBreakdown;
use App\Models\NonBankingService\Study;
use App\ReadyFunctions\PortfolioPresentValue;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioMortgageController extends Controller
{
    use NonBankingService ;
    public function getModel():PortfolioMortgageRevenueStreamBreakdown
    {
        return new PortfolioMortgageRevenueStreamBreakdown();
    }
    public function create(Company $company, Request $request, Study $study)
    {
        $model = $this->getModel();
        return view($model->getFormName(), $this->getModel()->getViewVars($company, $study));
    }

    protected function getRepeaterRelations():array
    {
        return [
            'portfolioMortgageRevenueProjectionByCategories'
        ];
    }
    public function store(Company $company, StorePortfolioMortgageRevenueStreamRequest $request, Study $study)
    {
            
        $study->storeRelationsWithNoRepeater($request, $company);
        $study->storeRepeaterRelations($request, $this->getRepeaterRelations(), $company);
    
        
        $dateIndexWithDate = app('dateIndexWithDate');
		$sumKeys = $study->getDateWithDateIndex();
        $isMonthlyStudy = $study->isMonthlyStudy();
        // question here
        // $study->updatePortfolioMortgageMonthlyAdminFeesAmounts();
        $operationDurationPerYearFromIndexes = $study->getOperationDurationPerYearFromIndexes();
        $baseRatePerYear = $study->generalAndReserveAssumption->getCbeLendingCorridorRates();
        $portfolioLoanFundingRatesPerYear = $request->input('new_loans_funding_rates');
        $bankMarginRatesPerYears = $study->generalAndReserveAssumption->getBankLendingMarginRates();
        $bankMarginRatesPerMonths = $isMonthlyStudy ? $bankMarginRatesPerYears : $study->convertYearlyArrayToMonthly($bankMarginRatesPerYears, $operationDurationPerYearFromIndexes);
        $cbeLendingRatesPerMonths =$isMonthlyStudy ? $baseRatePerYear: $study->convertYearlyArrayToMonthly($baseRatePerYear, $operationDurationPerYearFromIndexes);
        $portfolioLoanFundingRatesPerMonths = $isMonthlyStudy ? $portfolioLoanFundingRatesPerYear :  $study->convertYearlyArrayToMonthly($portfolioLoanFundingRatesPerYear, $operationDurationPerYearFromIndexes);
	//	$totalBankMonthlyLoanAmounts = [] ;
		$eclAndNewPortfolioFundingRate = null ;
		$totalMonthlyLoanAmounts = [];
		$totalPortfolioMonthlyLoanAmounts = [];
        foreach ($request->get('portfolioMortgageRevenueProjectionByCategories') as $currentIndex => $portfolioMortgageRevenueProjectionByCategoryArr) {
			$portfolioMortgageRevenueProjectionByCategory = $study->portfolioMortgageRevenueProjectionByCategories[$currentIndex] ;
            $portfolioMortgageCategoryId = $portfolioMortgageRevenueProjectionByCategory->id;
			// totalMonthlyAmountsPerYears
            $tenor = $portfolioMortgageRevenueProjectionByCategoryArr['portfolio_mortgage_duration'];
            $portfolioMortgageTransactionAmountsPerYears = $portfolioMortgageRevenueProjectionByCategoryArr['portfolio_mortgage_transactions_projections'];
            $marginRate = $portfolioMortgageRevenueProjectionByCategoryArr['margin_rate'];
			$monthlyStudyOccurrenceDates = HArr::onlyKeysWithValues($portfolioMortgageRevenueProjectionByCategoryArr['portfolio_mortgage_transactions_projections']??[]);
			$monthlyStudyOccurrenceDates = [$monthlyStudyOccurrenceDates];
		
     
            $frequencyPerYear = $portfolioMortgageRevenueProjectionByCategoryArr['frequency_per_year']??[];
            $startFromPerYear = $portfolioMortgageRevenueProjectionByCategoryArr['start_from']??[];
            $portfolioPresentValueResult = (new PortfolioPresentValue())->calculate($monthlyStudyOccurrenceDates,$study, $dateIndexWithDate, $portfolioLoanFundingRatesPerMonths, $operationDurationPerYearFromIndexes, $tenor, $startFromPerYear, $frequencyPerYear, $portfolioMortgageTransactionAmountsPerYears, $cbeLendingRatesPerMonths, $marginRate, $bankMarginRatesPerMonths, $company->id, $study->id, $portfolioMortgageCategoryId);
			$portfolioMortgageRevenueProjectionByCategory->update([
				'total_monthly_amounts_per_years'=>$portfolioPresentValueResult['total_monthly_amounts_per_years']
			]);
            DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('portfolio_mortgage_revenue_projection_by_categories')->where('id', $portfolioMortgageCategoryId)->update($portfolioPresentValueResult);
                
            $portfolioMonthlyLoanAmounts = [] ;
            foreach ($portfolioPresentValueResult['statement']??[] as $monthIndex => $portfolioMonthlyLoanArr) {
				$netPresentValue = $portfolioMonthlyLoanArr['net_present_value']??0;
                $portfolioMonthlyLoanAmounts[$monthIndex] = $netPresentValue;
                $totalPortfolioMonthlyLoanAmounts[$monthIndex] = isset($totalPortfolioMonthlyLoanAmounts[$monthIndex]) ? $totalPortfolioMonthlyLoanAmounts[$monthIndex] + $netPresentValue : $netPresentValue;
				
            }
            $bankMonthlyLoanAmounts = [] ;
            foreach ($portfolioPresentValueResult['statement']??[] as $monthIndex => $portfolioMonthlyLoanArr) {
			//	$currentBankLoanAmount = $portfolioMonthlyLoanArr['bank_loan_amount']??0 ;
				$bankMonthlyLoanAmounts[$monthIndex] = $portfolioMonthlyLoanArr['bank_loan_amount']??0;
                // $totalBankMonthlyLoanAmounts[$monthIndex] = isset($totalBankMonthlyLoanAmounts[$monthIndex]) ? $totalBankMonthlyLoanAmounts[$monthIndex] + $currentBankLoanAmount :$currentBankLoanAmount ;
            }
    		$occurrenceDates = HArr::onlyLastValuesInMultiArr($portfolioPresentValueResult['occurrence_dates']);
			$currentResult = $study->storeAdminFeesAndFundingStructureFor($request, Study::PORTFOLIO_MORTGAGE, $bankMonthlyLoanAmounts,$occurrenceDates);
			$currentMonthlyLoanFundingValues = $currentResult['monthly_new_loans_funding_values'];
			$eclAndNewPortfolioFundingRate = $currentResult['eclAndNewPortfolioFundingRate'];
			$totalMonthlyLoanAmounts = HArr::sumAtDates([$totalMonthlyLoanAmounts , $currentMonthlyLoanFundingValues ],$sumKeys);
			
				// $study->storeMonthlyLoan(Study::PORTFOLIO_MORTGAGE,'portfolioMortgageRevenueProjectionByCategories', $totalPortfolioMonthlyLoanAmounts);
            
        }
		$study->storeMonthlyLoan(Study::PORTFOLIO_MORTGAGE,'portfolioMortgageRevenueProjectionByCategories');
		if($eclAndNewPortfolioFundingRate){
	
			$eclAndNewPortfolioFundingRate->update([
				'monthly_new_loans_funding_values'=>$totalMonthlyLoanAmounts
			]);
		}
		$study->updateExpensesPercentageAndCostPerUnitsOfSales();
        if($request->get('save') === 'calculate-portfolio'){
			return response()->json([
            'redirectTo'=>route('create.portfolio.mortgage.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id])
        ]); 
		}
            
        // $study->calculatePortfolioDueCheques();
        // $study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
        return response()->json([
            'redirectTo'=>$study->getRevenueRoute(Study::MICROFINANCE)
        ]);
    }
    public function addNewCategory(Request $request, Company $company, Study $study)
    {
        $study->portfolioMortgageRevenueProjectionByCategories()->create([
            'company_id'=>$company->id
        ]);
        return redirect()->back();
    }
    public function deleteCategory(Request $request, Company $company, Study $study, PortfolioMortgageRevenueProjectionByCategory $portfolioMortgageCategory)
    {
        $portfolioMortgageCategoryId= $portfolioMortgageCategory->id ;
        $studyId = $study->id;
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id', $studyId)->where('revenue_stream_type', Study::PORTFOLIO_MORTGAGE)->where('revenue_stream_id', $portfolioMortgageCategoryId)->delete();
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('sensitivity_loan_schedule_payments')->where('study_id', $studyId)->where('revenue_stream_type', Study::PORTFOLIO_MORTGAGE)->where('revenue_stream_id',$portfolioMortgageCategoryId)->delete();
        $portfolioMortgageCategory->delete();
        return redirect()->back();
    }
}
