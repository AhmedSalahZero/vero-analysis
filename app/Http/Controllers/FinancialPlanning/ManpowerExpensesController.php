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
	
	public function storeDepartmentPositions(Company $company , Request $request,Study $study,string $expenseType){
		$addNewDepartment = $request->get('addNewDepartment') == 1;
		session()->put('addNewDepartment',$addNewDepartment);
		foreach($request->get('departments',[]) as $departmentId => $departmentArr){
			$department = Department::find($departmentId);

			
			$numberOfPositions = $departmentArr['no_positions'] ;
	
			$departmentData = [
				'name'=>$departmentArr['name'],
				'no_positions'=>$numberOfPositions,
				'type'=>$request->get('type'),
				'expense_type'=>$request->get('expense_type'),
				'study_id'=>$study->id,
				'company_id'=>$company->id,
			] ;
			if($department){
				$department->update($departmentData);
			}else{
				$department = Department::create($departmentData);
			}
			$oldPositionIdsFromDatabase = $department->positions->pluck('id')->toArray();
			$positions = $department->positions ;
			$newIdsFromRequest =array_column($departmentArr['positions']??[],'id') ;
			$additionalPositionsToDelete = [];
			foreach($request->input('departments.'.$department->id.'.positions',[]) as $positionIndex=>$positionArr){
				if($positionIndex >= $numberOfPositions ){
					$additionalPositionsToDelete[] =$positionArr['id'];
					continue ;
				}
				$hiringCounts = $positionArr['hiring_counts'];
				$currentExistingCount = $positionArr['existing_count'];
				$monthlyNetSalary = $positionArr['monthly_net_salary'];
		
				$operationStartDateAsIndex = $study->operation_start_month;
				$positionArr['study_id'] = $study->id ;
				$positionArr['company_id'] = $company->id ;
				$annualSalaryIncrease = $study->getAnnualSalaryIncreaseRate() ;  
				$salaryTaxesRate = $study->getSalaryTaxesRate() / 100;
				$socialInsuranceRate = $study->getSocialInsuranceRate() /100 ;
		        $dateAsIndexes = array_keys($hiringCounts);
				$additionalDatabaseResult =  Position::calculateManpowerResult($dateAsIndexes,$currentExistingCount,$hiringCounts,$operationStartDateAsIndex,$annualSalaryIncrease,$monthlyNetSalary,$salaryTaxesRate,$socialInsuranceRate);
				foreach($additionalDatabaseResult as $columnName => $payload){
					$positionArr[$columnName] = $payload;
				}
				$positionId = $positionArr['id'] ?? null; 
				$isToBeUpdated = isset($positionId) && in_array($positionId,$oldPositionIdsFromDatabase) && in_array($positionId,$newIdsFromRequest);
				$isToBeDeleted = isset($positionId) && in_array($positionId,$oldPositionIdsFromDatabase) && !in_array($positionId,$newIdsFromRequest) ;
				if($isToBeUpdated){
					$positions->where('id',$positionId)->first()->update($positionArr);
					continue ;
				}
				
				if($isToBeDeleted){
					$positions->where('id',$positionId)->delete();
					continue ; 
				}
				unset($positionArr['id']);
				$department->positions()->create($positionArr);
				
			}

			$department->positions()->whereIn('positions.id',$additionalPositionsToDelete)->delete();
			
			
			
			
			
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
