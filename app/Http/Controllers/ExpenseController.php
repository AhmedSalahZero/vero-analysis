<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class ExpenseController 
{
	public function create(Company $company)
	{
		$dates = [
			'01-01-2020',
			'01-02-2020',
			'01-03-2020',
			'01-04-2023',
			'01-05-2023',
			'01-06-2023',
		];
		
		return view('admin.ready-made-forms.expense',[
			'company'=>$company , 
			'pageTitle'=>__('Marketing Expense Form'),
			'storeRoute'=>route('admin.store.expense',['company'=>$company->id]),
			'type'=>'create',
			'dates'=>$dates	
		]);
	}
	// public function store($company_id,Request $request){
	// 	dd($company_id , $request);
	// }
}
