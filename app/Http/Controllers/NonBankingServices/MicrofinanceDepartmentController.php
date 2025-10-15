<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreDepartmentsRequest;
use App\Models\Company;
use App\Models\NonBankingService\Department;
use App\Models\NonBankingService\MicrofinanceDepartment;
use App\Models\NonBankingService\Position;
use App\Traits\NonBankingService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MicrofinanceDepartmentController extends Controller
{
	use NonBankingService ;
	
	public function create(Company $company , Request $request){
		
		return view('non_banking_services.microfinance-departments.form', $this->getViewVars($company));
	}
	protected function getViewVars(Company $company,$model = null){
		return [
			'company'=>$company ,
			'department'=>$model ,
			'title'=>__('Microfinance Departments'),
			'storeRoute'=>isset($model) ? route('update.microfinance-departments',['company'=>$company->id,'microfinanceDepartment'=>$model->id]) :route('store.microfinance-departments',['company'=>$company->id]),
		];
	}
	public function store(Company $company , StoreDepartmentsRequest $request)
	{
		$department = MicrofinanceDepartment::create($this->getCommonData($request,$company));
		$department->storeRepeaterRelations($request,['positions'],$company);
		return response()->json([
			'redirectTo'=>route('view.departments',['company'=>$company->id,'active'=>MicrofinanceDepartment::MICROFINANCE_DEPARTMENT])
		]);
	}
	public function getCommonData(Request $request,Company $company)
	{
		return [
			'name'=>$request->get('name'),
		//	'expense_type'=>$request->get('expense_type'),
			'type'=>'manpower',
			'company_id'=>$company->id 
		];
	}
	public function edit(Request $request , Company $company , MicrofinanceDepartment $microfinanceDepartment){
		return view('non_banking_services.microfinance-departments.form', $this->getViewVars($company,$microfinanceDepartment));
	}
	public function update(Request $request , Company $company , MicrofinanceDepartment $microfinanceDepartment){
	
		$microfinanceDepartment->update($this->getCommonData($request,$company));
		$microfinanceDepartment->storeRepeaterRelations($request,['positions'],$company);
		return response()->json([
			'redirectTo'=>route('view.departments',['company'=>$company->id,'active'=>MicrofinanceDepartment::MICROFINANCE_DEPARTMENT])
		]);
	}
	public function destroy(Request $request,Company  $company , MicrofinanceDepartment $microfinanceDepartment  ){
		$canBeDeleted = true ;
		// $microfinanceDepartment->positions->each(function(Position $position) use ($company,&$canBeDeleted){
		// 	$isExist = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('manpowers')->where('company_id',$company->id)->where('position_id',$position->id)->count();
		// 	if($isExist){
		// 		$canBeDeleted = false ;
		// 	}
			
		// }) ;
		if($canBeDeleted){
			$microfinanceDepartment->delete();
			return redirect()->back()->with('success',__('Done !'));	
			
		}
		return redirect()->back()->with('fail',__('This Item Cannot Be Deleted Because It’s Currently Used In A Study'));	
	}

}
