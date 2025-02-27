<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreReverseFactoringRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\ReverseFactoringRevenueStreamBreakdown;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;


class ReverseFactoringRevenueStreamBreakdownController extends Controller
{
	use NonBankingService ;
	public function getModel():ReverseFactoringRevenueStreamBreakdown
	{
		return new ReverseFactoringRevenueStreamBreakdown();
	}
	public function create(Company $company , Request $request,Study $study){
		$model = $this->getModel();
		return view($model->getFormName(), $this->getModel()->getViewVars($company,$study));
	}
	public function getRepeaterRelations():array 
	{
		return [
			'reverseFactoringBreakdowns'
		];
	}
	public function store(Company $company , StoreReverseFactoringRevenueStreamRequest $request,Study $study)
	{

			$study->storeRelationsWithNoRepeater($request,$company);
			$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
			$study->updateReverseFactoryMonthlyAdminFeesAmounts();
			$study->storeVariableLoans(Study::REVERSE_FACTORING,'reverseFactoringBreakdowns','reverseFactoringNewPortfolioFundingStructure');
			$study->updateExpensesOfSales();
		return response()->json([
			'redirectTo'=>route('create.ijara.mortgage.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id])
		]);
	}
}
