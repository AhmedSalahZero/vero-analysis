<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Department;
use App\Models\NonBankingService\ExpenseName;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class ExpensePerEmployeeController extends Controller
{
	use NonBankingService ;
	
	public function create(Company $company , Request $request){
		$study = Study::find($request->segment(5));
		
		return view('non_banking_services.expense-per-employee.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company,$model = null){
		$departmentsFormatted = $company->departments->sortBy('name')->pluck('name','id')->toArray() ;
		$departments = [];
		
		foreach($departmentsFormatted as $id=>$title){
			$departments[] = [
				'value'=>$id,
				'title'=>$title
			];
		}
		
		$expenseNamesPerCategoryFormatted = [];
		
		$expenseNamesPerCategory = ExpenseName::where('company_id', $company->id)->get()->groupBy('expense_type')->toArray();
		foreach(getEmployeeExpenseCategoriesForSelect2() as  $expenseNameArr){

				foreach($expenseNamesPerCategory[$expenseNameArr['value']]??[] as  $expenseArr){
					if($expenseArr['is_employee_expense']){
						$expenseNamesPerCategoryFormatted[$expenseArr['expense_type']][] = [
								'value'=>$expenseArr['id'],
								'title'=>$expenseArr['name']
							];
					}
				}
				
		}
		$positionsPerDepartments = [];
		$positions=[];
		foreach($departments as $departmentArr){
			$departmentId = $departmentArr['value'] ;
			$department = Department::find($departmentId);
			$currentPositions = $department->positions->pluck('name','id')->toArray();
			$positions[$departmentId] = HArr::mergeTwoAssocArr($positions[$departmentId]??[] , $currentPositions);
		}
		
		foreach($positions as $departmentIds => $positionArr){
			foreach($positionArr as $positionId => $positionTitle){
				$positionsPerDepartments[$departmentIds][] = ['value'=>$positionId,'title'=>$positionTitle];
			}
		}
		
		return [
			'company'=>$company ,
			'department'=>$model ,
			'title'=>__('Expense Per Employee'),
			'departmentsFormatted'=>$departments,
			'positionsPerDepartments'=>$positionsPerDepartments,
			'study'=>$model,
			'expenseType'=>'expense_per_employee',
			'model'=>$model,
			'storeRoute'=>route('store.expenses',['company'=>$company->id,'study'=>$model->id]),
			'expenseNamesPerCategoryFormatted'=>$expenseNamesPerCategoryFormatted
			// 'storeRoute'=>isset($model) ? route('update.departments',['company'=>$company->id,'department'=>$model->id]) :route('store.departments',['company'=>$company->id]),
		];
	}
	
	// الحسبة هنا
	// ExpensesController

}
