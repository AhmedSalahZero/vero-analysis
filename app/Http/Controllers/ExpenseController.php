<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\IncomeStatement;
use Illuminate\Http\Request;

class ExpenseController 
{
	public function create(Company $company)
	{
		// $dates = [
		// 	'01-01-2020',
		// 	'01-02-2020',
		// 	'01-03-2020',
		// 	'01-04-2023',
		// 	'01-05-2023',
		// 	'01-06-2023',
		// ];
		$model = IncomeStatement::first();
		// dd();
		return view('admin.ready-made-forms.expense',[
			'company'=>$company , 
			'pageTitle'=>__('Marketing Expense Form'),
			'storeRoute'=>route('admin.store.expense',['company'=>$company->id]),
			'type'=>'create',
			'dates'=>$model->getIntervalFormatted()	,
			'category'=>'expense',
			'model'=>$model 
		]);
	}
	public function store($company_id,Request $request){
		
		$modelId = $request->get('model_id');
		$modelName = $request->get('model_name');
		$model = ('\App\Models\\'.$modelName)::find($modelId);
		
		foreach((array)$request->get('tableIds') as $tableId){
			// delete all first 
			#::delete all
			// dd($request->get($tableId));
			$model->generateRelationDynamically($tableId)->delete();
			foreach((array)$request->get($tableId) as  $tableDataArr){
					$tableDataArr['relation_name']  = $tableId ;
					$tableDataArr['company_id']  = $company_id ;
					$tableDataArr['model_id']   = $modelId ;
					$tableDataArr['model_name']   = $modelName ;
					// dd($tableDataArr);
					if($tableDataArr['payment_terms'] == 'customize'){
						$tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate '],$tableDataArr['due_days']);
					}
					
					// if(isset($tableDataArr['id']) && $tableDataArr['id']  && is_numeric($tableDataArr['id'])){
					// 	dd($model , $model->generateRelationDynamically($tableId)->where('id',$tableDataArr['id']) , $tableDataArr['id']);
					// 	$model->generateRelationDynamically($tableId)->where('id',$tableDataArr['id'])->first()->update($tableDataArr);
					// }
					// else{
						$model->generateRelationDynamically($tableId)->create($tableDataArr);
					// }
					
				
			}
		}
		
		return redirect()->back()->with('success',__('Done'));
		
		
	}
}
