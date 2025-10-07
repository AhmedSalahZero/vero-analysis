<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreNewBranchFixedAssetsRequest;
use App\Http\Requests\NonBankingServices\StorePerEmployeeFixedAssetsRequest;
use App\Models\Company;
use App\Models\FinancialPlanning\Position;
use App\Models\NonBankingService\Department;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\FixedAsset;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class PerEmployeeFixedAssetsController extends Controller
{
	use NonBankingService ;
	public function create(Company $company , Request $request,Study $study){
		return view('non_banking_services.per-employee-fixed-assets.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		$studyMonthsForViews = $study->getStudyDurationPerYearFromIndexesForView();
		$yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		$newBranchCountPerDateIndex = $study->getNewBranchCountPerDateIndex();
	
		return [
			'company'=>$company ,
			'type'=>'create',
			'study'=>$study,
			'model'=>$study ,
			'expenseType'=>HHelpers::getClassNameWithoutNameSpace((new Expense())),
			'title'=>__('Per Employee Fixed Assets'),
			'monthsWithItsYear' => $study->getMonthsWithItsYear($yearWithItsIndexes),
			'studyMonthsForViews'=>$studyMonthsForViews,
			'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber(),
			'fixedAssetType'=>FixedAsset::PER_EMPLOYEE,
			'storeRoute'=>route('store.per.employee.fixed.assets',['company'=>$company->id,'study'=>$study->id]),
			'newBranchCountPerDateIndex'=>$newBranchCountPerDateIndex,
			'departmentFormattedForSelect2'=>Department::where('company_id',$company->id)->get()->formattedForSelect(false,'id','name'),
			
		];
	}
	protected function getRepeaterRelations():array
	{
		return [
			'fixedAssets'
		];
	}
	public function store(Company $company , StorePerEmployeeFixedAssetsRequest $request,Study $study)
	{
		$fixedAssetType = $request->get('fixed_asset_type') ;
		$study->storeRelationsWithNoRepeater($request,$company);
	
		$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
	//	$study->storeFixedLoansForFixedAssets($fixedAssetType);
		$study->recalculateFixedAssets($fixedAssetType);
	//	$study->recalculateFixedAssetStatement($fixedAssetType);

			
		return response()->json([
			'redirectTo'=>route('create.expenses',['company'=>$company->id,'study'=>$study->id])
		]);
		
	}
}
