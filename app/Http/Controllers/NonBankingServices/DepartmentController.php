<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreDepartmentsRequest;
use App\Models\Company;
use App\Models\NonBankingService\Department;
use App\Traits\NonBankingService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
	use NonBankingService ;
	protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'created_at' ; // change it 
		// $dateFieldName = $searchFieldName === 'balance_date' ? 'balance_date' : 'created_at'; 
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyReceived) use ($value,$searchFieldName){
				$currentValue = $moneyReceived->{$searchFieldName} ;
				// if($searchFieldName == 'bank_id'){
				// 	$currentValue = $moneyReceived->getBankName() ;  
				// }
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->sortByDesc('id')->values();
		
		return $collection;
	}
	
    public function index(Company $company , Request $request){
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',Department::DEPARTMENT);
		
		$filterDates = [];
		foreach([Department::DEPARTMENT] as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		
		
		 
		  /**
		 * * start of bank to safe internal money transfer 
		 */
		
		$startDate = $filterDates[Department::DEPARTMENT]['startDate'] ?? null ;
		$endDate = $filterDates[Department::DEPARTMENT]['endDate'] ?? null ;
		$departments = $company->departments ;
		// $departments =  $departments->filterByDateColumn('study_start_date',$startDate,$endDate) ;
		// dd($departments);
		$departments =  $currentType == Department::DEPARTMENT ? $this->applyFilter($request,$departments):$departments ;

		/**
		 * * end of bank to safe internal money transfer 
		 */
		 
		
		 $searchFields = [
			Department::DEPARTMENT=>[
				'name'=>__('Name'),
			],
		];
	
		$models = [
			Department::DEPARTMENT =>$departments ,
		];

        return view('non_banking_services.manpower-structure.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'filterDates'=>$filterDates,
			'title'=>__('Departments'),
			'tableTitle'=>__('Departments')
		]);
		
		
		
	}
	public function create(Company $company , Request $request){
		
		return view('non_banking_services.manpower-structure.form', $this->getViewVars($company));
	}
	protected function getViewVars(Company $company,$model = null){
		return [
			'company'=>$company ,
			'department'=>$model ,
			'title'=>__('Departments'),
			'storeRoute'=>isset($model) ? route('update.departments',['company'=>$company->id,'department'=>$model->id]) :route('store.departments',['company'=>$company->id]),
		];
	}
	public function store(Company $company , StoreDepartmentsRequest $request)
	{
		$department = Department::create($this->getCommonData($request,$company));
		$department->storeRepeaterRelations($request,['positions'],$company);
		return response()->json([
			'redirectTo'=>route('view.departments',['company'=>$company->id])
		]);
	}
	public function getCommonData(Request $request,Company $company)
	{
		return [
			'name'=>$request->get('name'),
			'expense_type'=>$request->get('expense_type'),
			'type'=>'manpower',
			'company_id'=>$company->id 
		];
	}
	public function edit(Request $request , Company $company , Department $department){
		return view('non_banking_services.manpower-structure.form', $this->getViewVars($company,$department));
	}
	public function update(Request $request , Company $company , Department $department){
		$department->update($this->getCommonData($request,$company));
		$department->storeRepeaterRelations($request,['positions'],$company);
		return response()->json([
			'redirectTo'=>route('view.departments',['company'=>$company->id])
		]);
	}
	public function destroy(Request $request,Company  $company , Department $department  ){
		$department->delete();
		return redirect()->back()->with('success',__('Done !'));	
	}

}
