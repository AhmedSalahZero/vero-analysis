<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Equations\ExpenseAsPercentageEquation;
use App\Equations\MonthlyFixedRepeatingAmountEquation;
use App\Equations\OneTimeExpenseEquation;
use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

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
			'title'=>__('Fixed Assets'),
			'storeRoute'=>route('store.ffe.fixed.assets',['company'=>$company->id , 'study'=>$study->id]),
			'monthsWithItsYear' => $study->getMonthsWithItsYear($yearWithItsIndexes),
			'studyMonthsForViews'=>$studyMonthsForViews,
			'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber()
			// 'revenueStreamTypes'=>$study->getCheckedRevenueStreamTypesForSelect()
		];
	}
	protected function getRepeaterRelations():array
	{
		return [
			'fixedAssets'
		];
	}
	public function store(Company $company , Request $request,Study $study)
	{
		$study->storeRelationsWithNoRepeater($request,$company);
	
		$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
		
		$study->storeFixedLoansForFixedAssets();
		// dd('good');
		
		return response()->json([
			'redirectTo'=>route('create.expenses',['company'=>$company->id,'study'=>$study->id])
		]);
		
	}
}
