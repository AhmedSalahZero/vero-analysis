<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreExpenseNamesRequest;
use App\Http\Requests\NonBankingServices\StoreFixedAssetNamesRequest;
use App\Http\Requests\StoreOpeningBalancesRequest;
use App\Models\Company;
use App\Models\NonBankingService\ExpenseName;
use App\Models\NonBankingService\FixedAssetName;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpeningBalancesController extends Controller
{
	use NonBankingService ;
	
	
   
	public function create(Company $company , Request $request,Study $study){
		return view('non_banking_services.openingBalances.form', array_merge($study->getOpeningBalancesViewVars(),['inEditMode'=>false]));
	}
	// protected function getViewVars(Company $company,?FixedAssetName $fixedAssetName = null){
	// 	return [
	// 		'company'=>$company ,
	// 		'title'=>__('Opening Balances'),
	// 		'fixedAssetNames'=>$fixedAssetName ? $company->fixedAssetNames : [],
	// 		'model'=>$fixedAssetName,
	// 		'storeRoute'=>$fixedAssetName ? route('update.fixed.asset.names',['company'=>$company->id,'fixedAssetName'=>$fixedAssetName->id]) : route('store.fixed.asset.names',['company'=>$company->id]),
	// 	];
	// }
	public function store(Company $company , StoreOpeningBalancesRequest $request,Study $study)
	{
	
		$study->storeRepeaterRelations($request, ['fixedAssetOpeningBalances','cashAndBankOpeningBalances','otherDebtorsOpeningBalances','vatAndCreditWithholdTaxesOpeningBalances'
        ,'supplierPayableOpeningBalances','otherCreditorsOpeningBalances','otherLongTermAssetsOpeningBalances','otherLongTermLiabilitiesOpeningBalances','equityOpeningBalances','longTermLoanOpeningBalances'
   		 ],$company, ['study_id'=>$study->id]);

		if($request->get('total_liabilities_and_equity_minus_total_assets') != 0){
			$errorMessage = __('Total Assets Must Be Equal To Total Liabilities + Owners Equity') . ' [ ' . number_format($request->get('total_liabilities_and_equity_minus_total_assets'))  . ' ]';
			 return redirect()->back()->with('error',$errorMessage);
		}
		return response()->json([
			'redirectTo'=>route('cash.in.out.flow.result',['company'=>$company->id])
		]);
	}
	public function getCommonData(Request $request,Company $company)
	{
		return [
			'name'=>$request->get('name'),
			'company_id'=>$company->id ,
		];
	}
	
	
	
	

}
