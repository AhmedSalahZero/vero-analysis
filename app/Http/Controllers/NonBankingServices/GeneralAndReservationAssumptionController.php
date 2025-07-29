<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\GeneralAndReserveAssumption;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class GeneralAndReservationAssumptionController extends Controller
{
	use NonBankingService ;
	public function create(Company $company , Request $request,Study $study){
		
		return view('non_banking_services.general-assumption.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		$yearsWithItsMonths =  $study->getOperationDurationPerYearFromIndexes() ;
		$yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
		$isYearsStudy = !$study->isMonthlyStudy();
		return [
			'company'=>$company ,
			'study'=>$study,
			'title'=>__('General Assumption'),
			'storeRoute'=>route('store.general.assumption',['company'=>$company->id , 'study'=>$study->id]),
			'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
			'isYearsStudy'=>$isYearsStudy,
			'yearsWithItsMonths'=>$yearsWithItsMonths,
			'model'=>$study->generalAndReserveAssumption ? $study->generalAndReserveAssumption : null 
		];
	}
	public function store(Company $company , Request $request,Study $study)
	{
		$data = $request->except(['_token','save','_method']) ;
		$study->generalAndReserveAssumption ? $study->generalAndReserveAssumption->update($data) : GeneralAndReserveAssumption::create($data);
		
		return response()->json([
			'redirectTo'=>route('create.microfinance.branches.assumption',['company'=>$company->id,'study'=>$study->id])
		]);
	}
}
