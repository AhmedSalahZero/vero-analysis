<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StorePortfolioMortgageRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\PortfolioMortgageRevenueStreamBreakdown;
use App\Models\NonBankingService\Study;
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
			// $study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
		
		return response()->json([
			'redirectTo'=>route('create.expenses',['company'=>$company->id,'study'=>$study->id])
		]);
	}
}
