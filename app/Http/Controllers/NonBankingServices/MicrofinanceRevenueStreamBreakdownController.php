<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreMicrofinanceRevenueStreamRequest;
use App\Models\Company;
use App\Models\Loan;
use App\Models\NonBankingService\MicrofinanceRevenueStreamBreakdown;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class MicrofinanceRevenueStreamBreakdownController extends Controller
{
	use NonBankingService ;
	public function getModel():MicrofinanceRevenueStreamBreakdown
	{
		return new MicrofinanceRevenueStreamBreakdown();
	}
	public function create(Company $company , Request $request,Study $study){
		$model = $this->getModel();
		return view($model->getFormName(), $this->getModel()->getViewVars($company,$study));
	}
	public function getRepeaterRelations():array 
	{
		return [
			'microfinanceBreakdowns'
		];
	}
	public function store(Company $company , Request $request,Study $study)
	{
		// dd($request->all());
		$operationDurationPerYearFromIndexes = $study->getOperationDurationPerYearFromIndexes();
		// $flatRates = array_column($request->input('microfinanceBreakdowns',[]),'flat_rates');
		$pricingPerMonths=[];
		foreach($request->input('microfinanceBreakdowns',[]) as $items){
			$flatRateArr = $items['flat_rates'];
			$currentTenor = $items['tenor'];
			
			$currentFlatRatePerMonths = $study->convertYearlyArrayToMonthly($flatRateArr,$operationDurationPerYearFromIndexes);
			foreach($currentFlatRatePerMonths as $currentMonthIndex => $currentFlatRate){
				$pricingPerMonths[$currentMonthIndex] = Loan::convertFlatRateToDecreasingRate($currentFlatRate/100,$currentTenor);
			}
	
		}
	
		$study->storeRelationsWithNoRepeater($request,$company);
		$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
		$study->refresh();
		$study->updateMicrofinanceMonthlyAdminFeesAmounts();
		$study->storeFixedLoans(Study::MiCROFINANCE,'microfinanceBreakdowns','microfinanceNewPortfolioFundingStructure',false,$pricingPerMonths);
		$study->updateExpensesPercentagesOfSales();
		
		return response()->json([
			'redirectTo'=>route('create.portfolio.mortgage.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id])
		]);
	}
}
