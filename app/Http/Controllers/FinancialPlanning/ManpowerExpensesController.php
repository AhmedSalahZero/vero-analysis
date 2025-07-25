<?php

namespace App\Http\Controllers\FinancialPlanning;

use App\Equations\ExpenseAsPercentageEquation;
use App\Equations\MonthlyFixedRepeatingAmountEquation;
use App\Equations\OneTimeExpenseEquation;
use App\Helpers\HArr;
use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\FinancialPlanning\Department;
use App\Models\FinancialPlanning\Expense;
use App\Models\FinancialPlanning\Position;
use App\Models\FinancialPlanning\Study;
use Illuminate\Http\Request;

class ManpowerExpensesController extends Controller
{
	public function create(Company $company , Request $request,Study $study,string $expenseType){
		
		return view('financial_planning.manpower.form', $this->getViewVars($company,$study,$expenseType));
	}
	protected function getViewVars(Company $company, Study $study,string $expenseType){
		$studyMonthsForViews = $study->getStudyDurationPerYearFromIndexesForView() ;
		return [
			'company'=>$company ,
			'type'=>getLastSegmentInRequest(),
			'study'=>$study,
			'model'=>$study ,
			'expenseType'=>$expenseType,
			'title'=>__('Manpower Expenses')  . ' [ '. str_to_upper($expenseType) . ' ]',
			'storeRoute'=>route('store.manpower',['company'=>$company->id , 'study'=>$study->id,'expenseType'=>$expenseType]),
			'studyMonthsForViews'=>$studyMonthsForViews,
			'departments'=>$study->departmentsFor(Request()->segment(7),Request()->segment(6)),
			'storeDepartmentPositionsRoute'=>route('store.department.positions',['company'=>$company->id,'expenseType'=>$expenseType,'study'=>$study->id]),
			'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber()
		];
	}
	
	public function store(Company $company , Request $request,Study $study,MonthlyFixedRepeatingAmountEquation $monthlyFixedRepeatingAmountEquation,
	ExpenseAsPercentageEquation $expenseAsPercentageEquation,
	OneTimeExpenseEquation $oneTimeExpenseEquation
	)
	{
		
		
		$modelId = $request->get('model_id');
		$modelName = $request->get('model_name');
		$expenseType = $request->get('expense_type');
		// $studyId = $study->id;
		$datesAsStringDateIndex = $study->getDatesAsStringAndIndex();
		$operationStartDateAsIndex = $datesAsStringDateIndex[$study->getOperationStartDate()];
		$model = ('\App\Models\\FinancialPlanning\\'.$modelName)::find($modelId);

		foreach((array)$request->get('tableIds') as $tableId){
			#::delete all
			$model->generateRelationDynamically($tableId,$expenseType)->delete();
			foreach((array)$request->get($tableId) as  $tableDataArr){
				$tableDataArr['expense_type'] = $expenseType;
					$name = $tableDataArr['name'];
					if(isset($tableDataArr['start_date'])){
						$tableDataArr['start_date'] = $datesAsStringDateIndex[$tableDataArr['start_date']];
					}else{
						$tableDataArr['start_date'] = $operationStartDateAsIndex;
					}
					if(isset($tableDataArr['end_date'])){
						$tableDataArr['end_date'] = $datesAsStringDateIndex[$tableDataArr['end_date']];
					}else{
						$tableDataArr['end_date'] = $operationStartDateAsIndex;
					}
					$tableDataArr['relation_name']  = $tableId ;
					
					$tableDataArr['company_id']  = $company->id ;
					$tableDataArr['model_id']   = $modelId ;
					$tableDataArr['model_name']   = $modelName ;
					
					if(($tableDataArr['payment_terms']??null) == 'customize'){
						$tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate '],$tableDataArr['due_days']);
					}
					if($name){
						$model->generateRelationDynamically($tableId,$expenseType)->create($tableDataArr);
					}
					
				
			}
		}
		return response()->json([
			'redirectTo'=>route('view.manpower',['company'=>$company->id,'expenseType'=>$expenseType,'study'=>$study->id])
		]);
	}
	
	public function deleteSinglePosition(Company $company , Request $request,Study $study,Position $position)
	{
		$position->delete();
		$department = $position->department ;
		$department->update([
			'no_positions'=>$department->getNoPositions() - 1 
		]);
		
		return redirect()->back();
	}
	public function deleteSingleDepartment(Company $company , Request $request,Study $study,Department $department)
	{

		$department->delete();
			
		return redirect()->back();
	}
}
