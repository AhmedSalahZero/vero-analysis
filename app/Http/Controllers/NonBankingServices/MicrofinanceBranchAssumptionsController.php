<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreMicrofinanceBranchAssumption;
use App\Models\Company;
use App\Models\NonBankingService\Department;
use App\Models\NonBankingService\Position;
use App\Models\NonBankingService\Study;
use Illuminate\Http\Request;

class MicrofinanceBranchAssumptionsController extends Controller
{
	public function create(Company $company , Request $request,Study $study){
		return view('non_banking_services.microfinance-branch-assumptions.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		$studyMonthsForViews = collect($study->getStudyDurationPerYearFromIndexesForView())->take(12)->toArray() ;
		
		return [
			'company'=>$company ,
			// 'type'=>getLastSegmentInRequest(),
			'study'=>$study,
			'model'=>$study ,
			'title'=>__('Microfinance Branches Assumptions')  ,
			'storeRoute'=>route('store.microfinance.branches.assumption',['company'=>$company->id , 'study'=>$study->id]),
			'studyMonthsForViews'=>$studyMonthsForViews,
		];
	}
	protected function getRepeaterRelations():array
	{
		return [
			'existingBranchesLoanCases',
			'newBranchOpeningProjections',
			'newBranchLoanCaseProjections'
		];
	}
	public function store(Company $company , StoreMicrofinanceBranchAssumption $request,Study $study)
	{
	
		$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
		return redirecT()->route('create.leasing.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id]);
		// return response()->json([
		// 	'redirectTo'=>route('create.leasing.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id])
		// ]);
		
		// $modelId = $request->get('model_id');
		// $modelName = $request->get('model_name');
		// $expenseType = $request->get('expense_type');
		// $datesAsStringDateIndex = $study->getDatesAsStringAndIndex();
		// $operationStartDateAsIndex = $datesAsStringDateIndex[$study->getOperationStartDate()];
		// $model = ('\App\Models\\NonBankingService\\'.$modelName)::find($modelId);

		// foreach((array)$request->get('tableIds') as $tableId){
		// 	#::delete all
		// 	$model->generateRelationDynamically($tableId,$expenseType)->delete();
		// 	foreach((array)$request->get($tableId) as  $tableDataArr){
		// 			$tableDataArr['expense_type'] = $expenseType  ;
		// 			$tableDataArr['is_deductible'] = isset($tableDataArr['is_deductible']) ? $tableDataArr['is_deductible'][0] :0;
		// 			$name = $tableDataArr['name'];
		// 			if(isset($tableDataArr['start_date'])){
		// 				$tableDataArr['start_date'] = $datesAsStringDateIndex[$tableDataArr['start_date']];
		// 			}else{
		// 				$tableDataArr['start_date'] = $operationStartDateAsIndex;
		// 			}
		// 			if(isset($tableDataArr['end_date'])){
		// 				$tableDataArr['end_date'] = $datesAsStringDateIndex[$tableDataArr['end_date']];
		// 			}else{
		// 				$tableDataArr['end_date'] = $operationStartDateAsIndex;
		// 			}
		// 			$tableDataArr['relation_name']  = $tableId ;
					
		// 			$tableDataArr['company_id']  = $company->id ;
		// 			$tableDataArr['model_id']   = $modelId ;
		// 			$tableDataArr['model_name']   = $modelName ;
					
		// 			if(($tableDataArr['payment_terms']??null) == 'customize'){
		// 				$tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate '],$tableDataArr['due_days']);
		// 			}
		// 			if($name){
					
		// 				$model->generateRelationDynamically($tableId,$expenseType)->create($tableDataArr);
		// 			}
					
				
		// 	}
		// }
	
		
	}
	
	public function storeDepartmentPositions(Company $company , Request $request,Study $study){
		$addNewDepartment = $request->get('addNewDepartment') == 1;
		session()->put('addNewDepartment',$addNewDepartment);
		foreach($request->get('departments',[]) as $departmentId => $departmentArr){
			$departmentName = $departmentArr['name'] ;
			if(is_null($departmentName)){
				continue ;
			}
			$department = Department::find($departmentId);

			
			$numberOfPositions = $departmentArr['no_positions'] ;
	
			$departmentData = [
				'name'=>$departmentName,
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
				// $positionArr['manpower_salaries'] = 
				$generalAndReserveAssumption = $study->generalAndReserveAssumption;
				
				$salaryTaxesRate = $study->getSalaryTaxesRate() / 100;
				$socialInsuranceRate = $study->getSocialInsuranceRate() /100 ;
		        $dateAsIndexes = array_keys($hiringCounts);
				$additionalDatabaseResult =  $study->calculateManpowerResult($dateAsIndexes,$currentExistingCount,$hiringCounts,$operationStartDateAsIndex,$monthlyNetSalary,$salaryTaxesRate,$socialInsuranceRate);
			
				
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
			'redirectTo'=>route('view.manpower.for.non.banking',['company'=>$company->id,'study'=>$study->id])
		]);
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
	public function deleteSingleDepartment(Company $company , Request $request,Study $study,Department $department)
	{
		$department->delete();
		return redirect()->back();
	}
	public function getPositionsBasedOnDepartment(Company $company,Request $request,Study $study){
		$department  = Department::find($request->get('departmentId'));

		return response()->json([
			'status'=>true ,
			'positions'=>$department->positions->pluck('name','id')->toArray()
		]);
	}
}
