<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Partner;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PartnersStatementController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		$partnerTypes = ['is_subsidiary_company'=>__('Subsidiary Company') , 'is_shareholder'=>__('Shareholder') , 'is_employee'=>__('Employee')];
		
        return view('partners_statement_form', [
			'company'=>$company,
			'partnerTypes'=>$partnerTypes
		]);
    }
	public function result(Company $company , Request $request){
		
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');
		$partnerType = $request->get('partner_type');
		$currency = $request->get('currency');
		$partnerId = $request->get('partner_id');
		$partner = Partner::find($partnerId);
		$statementTableName = [
			'is_subsidiary_company'=>'subsidiary_company_statements',
			'is_shareholder'=>'shareholder_statements',
			'is_employee'=>'employee_statements',
		][$partnerType] ;
		
		$results=DB::table($statementTableName)
		->where('company_id',$company->id)
		->where('currency_name',$currency)
		->where('partner_id',$partnerId)
		->where('date','>=',$startDate)
		->where('date','<=',$endDate)
		->orderByRaw('full_date asc , created_at asc')
		->get();
			if(!count($results)){
				return redirect()
									->back()
									->with('fail',__('No Data Found'))	
									;
			}
		
		return view('partners_statement_result',[
			'results'=>$results,
			'currency'=>$currency,
			'partner'=>$partner
		]);
	}




}
