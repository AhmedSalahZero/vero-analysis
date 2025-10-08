<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFixedAssetsRequest;
use App\Models\Company;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\FixedAsset;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class FfeFixedAssetsController extends Controller
{
    use NonBankingService ;
    public function create(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.ffe-fixed-assets.form', $this->getViewVars($company, $study));
    }
    public function createFundingStructure(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.ffe-fixed-assets.funding-form', $this->getViewVars($company, $study));
    }
    protected function getViewVars(Company $company, Study $study)
    {
        $studyMonthsForViews = $study->getStudyDurationPerYearFromIndexesForView();
        $yearWithItsIndexes = $study->getOperationDurationPerYearFromIndexes();
		$fundingStructureCounts = $study->getFixedAssetsWithCountsDates(FixedAsset::FFE);
        return [
			'fundingStructureCounts'=>$fundingStructureCounts,
            'company'=>$company ,
            'type'=>'create',
            'study'=>$study,
            'model'=>$study ,
            'expenseType'=>HHelpers::getClassNameWithoutNameSpace((new Expense())),
            'title'=>__('FFE Fixed Assets'),
            'storeRoute'=>route('store.ffe.fixed.assets', ['company'=>$company->id , 'study'=>$study->id]),
            'storeFundingRoute'=>route('store.ffe.funding.structure.fixed.assets', ['company'=>$company->id , 'study'=>$study->id]),
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
    public function store(Company $company, StoreFixedAssetsRequest $request, Study $study)
    {
        $fixedAssetType = $request->get('fixed_asset_type') ;

   
		$loanStructure = $study->getLoanStructure($fixedAssetType);
		
		
   	  $study->storeRepeaterRelations($request, $this->getRepeaterRelations(), $company, ['type'=>$fixedAssetType]);
        

        $isFullyFundedThroughEquity = $request->input('generalFixedAssetsFundingStructure.is_fully_funded_though_equity');
		if($isFullyFundedThroughEquity && $loanStructure){
			 $loanStructure->delete();
		}
		$study->recalculateFixedAssets($fixedAssetType);
        if (!$isFullyFundedThroughEquity) {
            return response()->json([
            'redirectTo'=>route('create.ffe.funding.structure.fixed.assets', ['company'=>$company->id,'study'=>$study->id])
        ]);
        }
        
        return response()->json([
            'redirectTo'=>route('create.expenses', ['company'=>$company->id,'study'=>$study->id])
        ]);
        
    }
	  public function storeFunding(Company $company, StoreFixedAssetsRequest $request, Study $study)
    {
        $fixedAssetType = $request->get('fixed_asset_type') ;

        $study->storeRelationsWithNoRepeater($request, $company);

		$study->recalculateFixedAssets($fixedAssetType);
        
        return response()->json([
            'redirectTo'=>route('create.expenses', ['company'=>$company->id,'study'=>$study->id])
        ]);
        
    }
}
