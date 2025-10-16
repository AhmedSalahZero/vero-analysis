<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Department;
use App\Models\NonBankingService\Manpower;
use App\Models\NonBankingService\Position;
use App\Models\NonBankingService\Study;
use Illuminate\Http\Request;

class ManpowerExpensesController extends Controller
{
	public function create(Company $company , Request $request,Study $study){
		return view('non_banking_services.manpower.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		$studyMonthsForViews =array_flip($study->getOperationDatesAsDateAndDateAsIndexToStudyEndDate()) ;
		return [
			'company'=>$company ,
			'type'=>getLastSegmentInRequest(),
			'study'=>$study,
			'model'=>$study ,
			'title'=>__('Manpower Expenses')  ,
			'expenseType'=>'manpower',
			'storeRoute'=>route('store.manpower.for.non.banking',['company'=>$company->id , 'study'=>$study->id]),
			'studyMonthsForViews'=>$studyMonthsForViews,
			'departments'=>$company->departmentsFor(Request()->segment(6),$company->id),
			'storeDepartmentPositionsRoute'=>route('store.department.positions.for.non.banking',['company'=>$company->id,'study'=>$study->id]),
			'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber()
		];
	}
	
	public function store(Company $company , Request $request,Study $study)
	{
		$modelId = $request->get('model_id');
		$modelName = $request->get('model_name');
		$expenseType = $request->get('expense_type');
		$datesAsStringDateIndex = $study->getDatesAsStringAndIndex();
		$operationStartDateAsIndex = $datesAsStringDateIndex[$study->getOperationStartDate()];
		$model = ('\App\Models\\NonBankingService\\'.$modelName)::find($modelId);

		foreach((array)$request->get('tableIds') as $tableId){
			#::delete all
			$model->generateRelationDynamically($tableId,$expenseType)->delete();
			foreach((array)$request->get($tableId) as  $tableDataArr){
					$tableDataArr['expense_type'] = $expenseType  ;
					$tableDataArr['is_deductible'] = isset($tableDataArr['is_deductible']) ? $tableDataArr['is_deductible'][0] :0;
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
			'redirectTo'=>route('view.manpower.for.non.banking',['company'=>$company->id,'study'=>$study->id])
		]);
	}
	
	public function storeDepartmentPositions(Company $company , Request $request,Study $study){
		// $addNewDepartment = $request->get('addNewDepartment') == 1;
		// session()->put('addNewDepartment',$addNewDepartment);
			 $dateAsIndexes = $study->getDateWithDateIndex();
		foreach($request->get('manpowers',[]) as $positionId => $manpowerArr){
			
				$position = Position::find($positionId);
				$manpower = $position->manpowers->where('study_id',$study->id)->first() ;
				$manpower = $manpower ?:new Manpower ;
				$manpower->position_id = $positionId;
				$manpower->study_id = $study->id;
				$manpower->company_id = $company->id;
				$hiringCounts = $manpowerArr['hiring_counts'];
				$manpower->hiring_counts = $hiringCounts;
				$monthlyNetSalary = $manpowerArr['monthly_net_salary'];
				$manpower->monthly_net_salary =$monthlyNetSalary ;
				$currentExistingCount = $manpowerArr['existing_count'];
				$manpower->existing_count = $currentExistingCount;
				$operationStartDateAsIndex = $study->operation_start_month;
				
				$salaryTaxesRate = $study->getSalaryTaxesRate() / 100;
				$socialInsuranceRate = $study->getSocialInsuranceRate() /100 ;
				$additionalDatabaseResult =  $study->calculateManpowerResult($dateAsIndexes,$currentExistingCount,$hiringCounts,$operationStartDateAsIndex,$monthlyNetSalary,$salaryTaxesRate,$socialInsuranceRate);
				
				foreach($additionalDatabaseResult as $columnName => $payload){
					$manpower[$columnName] = $payload;
				}
					$manpower->save();
				
				

		//	$department->positions()->whereIn('positions.id',$additionalPositionsToDelete)->delete();
		}
		return redirect()->route('create.expense.per.employees',['company'=>$company->id,'study'=>$study->id]);
		// return response()->json([
		// 	'redirectTo'=>route('view.manpower.for.non.banking',['company'=>$company->id,'study'=>$study->id])
		// ]);
	}
	// public function deleteSinglePosition(Company $company , Request $request,Study $study,Position $position)
	// {

	// 	$position->delete();
	// 	$department = $position->department ;
	// 	$department->update([
	// 		'no_positions'=>$department->getNoPositions() - 1 
	// 	]);
		
	// 	return redirect()->back();
	// }
	// public function deleteSingleDepartment(Company $company , Request $request,Study $study,Department $department)
	// {

	// 	$department->delete();
			
	// 	return redirect()->back();
	// }
	public function getPositionsBasedOnDepartment(Company $company,Request $request,Study $study){
		$positions = [];
		foreach($request->get('departmentId',[]) as $departmentId){
			$department  = Department::find($departmentId);
			$currentPositions = $department->positions->pluck('name','id')->toArray();
			$positions = HArr::mergeTwoAssocArr($positions , $currentPositions);
		}
		return response()->json([
			'status'=>true ,
			'positions'=>$positions
		]);
	}
}
