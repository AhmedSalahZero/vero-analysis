<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\FixedAsset;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFixedAssetsRequest;

class FfeFixedAssetsController extends Controller
{
	use NonBankingService ;
	public function create(Company $company , Request $request,Study $study){
		return view('non_banking_services.ffe-fixed-assets.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		$studyMonthsForViews = $study->getStudyDurationPerYearFromIndexesForView();
		$yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		return [
			'company'=>$company ,
			'type'=>'create',
			'study'=>$study,
			'model'=>$study ,
			'expenseType'=>HHelpers::getClassNameWithoutNameSpace((new Expense())),
			'title'=>__('FFE Fixed Assets'),
			'storeRoute'=>route('store.ffe.fixed.assets',['company'=>$company->id , 'study'=>$study->id]),
			'monthsWithItsYear' => $study->getMonthsWithItsYear($yearWithItsIndexes),
			'studyMonthsForViews'=>$studyMonthsForViews,
			'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber(),
			'fixedAssetType'=>FixedAsset::FFE
		];
	}
	protected function getRepeaterRelations():array
	{
		return [
			'fixedAssets'
		];
	}
	public function store(Company $company , StoreFixedAssetsRequest $request,Study $study)
	{
		$fixedAssetType = $request->get('fixed_asset_type') ;

		$study->storeRelationsWithNoRepeater($request,$company);
	
		$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company,['type'=>$fixedAssetType]);
		
	//	$study->storeFixedLoansForFixedAssets($fixedAssetType);
		$study->recalculateFixedAssets($fixedAssetType);
	//	$study->recalculateFixedAssetStatement($fixedAssetType);
		
		return response()->json([
			'redirectTo'=>route('create.expenses',['company'=>$company->id,'study'=>$study->id])
		]);
		
	}
}
