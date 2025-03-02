<?php

namespace App\Http\Controllers\NonBankingServices;

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

class PortfolioMortgageRevenueStreamBreakdownController extends Controller
{
	use NonBankingService ;
	public function getModel():PortfolioMortgageRevenueStreamBreakdown
	{
		return new PortfolioMortgageRevenueStreamBreakdown();
	}
	public function create(Company $company , Request $request,Study $study){
		$model = $this->getModel();
		return view($model->getFormName(), $this->getModel()->getViewVars($company,$study));
	}
	// public function getRepeaterRelations():array 
	// {
	// 	return [
	// 		'portfolioMortgageBreakdowns'
	// 	];
	// }
	protected function getRepeaterRelations():array
	{
		return [
			'portfolioMortgageRevenueProjectionByCategories'
		];
	}
	public function store(Company $company , StorePortfolioMortgageRevenueStreamRequest $request,Study $study)
	{	
			
			$study->storeRelationsWithNoRepeater($request,$company);
			$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
			$study = $study->refresh();
			$dateIndexWithDate = app('dateIndexWithDate');
			// question here 
			// $study->updatePortfolioMortgageMonthlyAdminFeesAmounts();
			$operationDurationPerYearFromIndexes = $study->getOperationDurationPerYearFromIndexes();
			$baseRatePerYear = $study->generalAndReserveAssumption->getCbeLendingCorridorRates();
			$portfolioLoanFundingRatesPerYear = $request->input('portfolioMortgageNewPortfolioFundingStructure.new_loans_funding_rates');
			$bankMarginRatesPerYears = $study->generalAndReserveAssumption->getBankLendingMarginRates();
			$bankMarginRatesPerMonths = $study->convertYearlyArrayToMonthly($bankMarginRatesPerYears,$operationDurationPerYearFromIndexes);
			$cbeLendingRatesPerMonths = $study->convertYearlyArrayToMonthly($baseRatePerYear,$operationDurationPerYearFromIndexes);
			$portfolioLoanFundingRatesPerMonths = $study->convertYearlyArrayToMonthly($portfolioLoanFundingRatesPerYear,$operationDurationPerYearFromIndexes);
			// $study = $study->refresh();
			// dd($request->all());
			// dB::table('loan_schedule_payments')->deleteAllForPortfolio
			foreach($request->get('portfolioMortgageRevenueProjectionByCategories') as $currentIndex => $portfolioMortgageRevenueProjectionByCategoryArr){
				$portfolioMortgageCategoryId = $study->portfolioMortgageRevenueProjectionByCategories[$currentIndex]->id; 
				$tenor = $portfolioMortgageRevenueProjectionByCategoryArr['portfolio_mortgage_duration'];
				$portfolioMortgageTransactionAmountsPerYears = $portfolioMortgageRevenueProjectionByCategoryArr['portfolio_mortgage_transactions_projections'];
				$frequencyPerYear = $portfolioMortgageRevenueProjectionByCategoryArr['frequency_per_year'];
				$startFromPerYear = $portfolioMortgageRevenueProjectionByCategoryArr['start_from'];
				$marginRate = $portfolioMortgageRevenueProjectionByCategoryArr['margin_rate'];
		    	 (new PortfolioPresentValue())->calculate($dateIndexWithDate,$portfolioLoanFundingRatesPerMonths,$operationDurationPerYearFromIndexes,$tenor,$startFromPerYear,$frequencyPerYear,$portfolioMortgageTransactionAmountsPerYears,$cbeLendingRatesPerMonths,$marginRate,$bankMarginRatesPerMonths,$company->id,$study->id,$portfolioMortgageCategoryId);
			}
		
			
			
			// $study->calculatePortfolioDueCheques();
			// $study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
		return response()->json([
			'redirectTo'=>route('view.manpower.for.non.banking',['company'=>$company->id,'study'=>$study->id])
		]);
	}
	public function addNewCategory(Request $request , Company $company , Study $study)
	{
		$study->portfolioMortgageRevenueProjectionByCategories()->create([
			'company_id'=>$company->id
		]);
		return redirect()->back();
	}
	public function deleteCategory(Request $request , Company $company , Study $study,PortfolioMortgageRevenueProjectionByCategory $portfolioMortgageCategory)
	{
		$portfolioMortgageCategoryId= $portfolioMortgageCategory->id ;
		$studyId = $study->id;
		DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id',$studyId)->where('revenue_stream_type',Study::PORTFOLIO_MORTGAGE)->where('revenue_stream_id',$portfolioMortgageCategoryId)->delete();
		DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('sensitivity_loan_schedule_payments')->where('study_id',$studyId)->where('revenue_stream_type',Study::PORTFOLIO_MORTGAGE)->where('revenue_stream_id',$portfolioMortgageCategoryId)->delete();
		$portfolioMortgageCategory->delete();
		return redirect()->back();
	}
}
