<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StorePortfolioMortgageRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\PortfolioMortgageRevenueStreamBreakdown;
use App\Models\NonBankingService\Study;
use App\ReadyFunctions\PortfolioPresentValue;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

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
	public function store(Company $company , StorePortfolioMortgageRevenueStreamRequest $request,Study $study)
	{
			$study->storeRelationsWithNoRepeater($request,$company);
			$study = $study->refresh();
			$dateIndexWithDate = app('dateIndexWithDate');
			$study->updatePortfolioMortgageMonthlyAdminFeesAmounts();
			$portfolioMortgageTransactionAmountsPerYears = $request->input('PortfolioMortgageRevenueProjectionByCategory.portfolio_mortgage_transactions_projections');
		
			$frequencyPerYear = $request->input('PortfolioMortgageRevenueProjectionByCategory.frequency_per_year');
			$startFromPerYear = $request->input('PortfolioMortgageRevenueProjectionByCategory.start_from');
			
			$operationDurationPerYearFromIndexes = $study->getOperationDurationPerYearFromIndexes();
			$baseRatePerYear = $study->generalAndReserveAssumption->getCbeLendingCorridorRates();
			$portfolioLoanFundingRatesPerYear = $request->input('portfolioMortgageNewPortfolioFundingStructure.new_loans_funding_rates');
			$pricingPerMonth = [];
			$marginRate = $request->input('PortfolioMortgageRevenueProjectionByCategory.margin_rate',0);
			$tenor = $request->get('portfolio_mortgage_duration',1);
			$bankMarginRatesPerYears = $study->generalAndReserveAssumption->getBankLendingMarginRates();
			$bankMarginRatesPerMonths = $study->convertYearlyArrayToMonthly($bankMarginRatesPerYears,$operationDurationPerYearFromIndexes);
			$cbeLendingRatesPerMonths = $study->convertYearlyArrayToMonthly($baseRatePerYear,$operationDurationPerYearFromIndexes);
			$portfolioLoanFundingRatesPerMonths = $study->convertYearlyArrayToMonthly($portfolioLoanFundingRatesPerYear,$operationDurationPerYearFromIndexes);
			$portfolioPresentValue = (new PortfolioPresentValue())->calculate($dateIndexWithDate,$portfolioLoanFundingRatesPerMonths,$operationDurationPerYearFromIndexes,$tenor,$startFromPerYear,$frequencyPerYear,$portfolioMortgageTransactionAmountsPerYears,$cbeLendingRatesPerMonths,$marginRate,$bankMarginRatesPerMonths);
			
			// $study->calculatePortfolioDueCheques();
			// $study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
		
		return response()->json([
			'redirectTo'=>route('view.manpower.for.non.banking',['company'=>$company->id,'study'=>$study->id])
		]);
	}
}
