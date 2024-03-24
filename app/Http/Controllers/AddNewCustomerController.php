<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Partner;
use Illuminate\Http\Request;

class AddNewCustomerController extends Controller
{
	public function addNew(Company $company , Request $request){
		$customerName = $request->get('customerName');
		$isExist = Partner::where('is_customer',1)->where('name',$customerName)->exists();
		if($isExist){
			return response()->json([
				'status'=>false ,
				'message'=>__('This Customer Already Exist')
			]);
		}
		$partner = Partner::create([
			'name'=>$customerName ,
			'is_customer'=>1 ,
			'company_id'=>$company->id 
		]);
		return response()->json([
			'status'=>true ,
			'customer'=>[
				'id'=> $partner->id   ,
				'name'=>$customerName
			]
		]);
		
	}
}
