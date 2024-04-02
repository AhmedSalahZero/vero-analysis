<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Partner;
use Illuminate\Http\Request;

class AddNewCustomerController extends Controller
{
	public function addNew(Company $company , Request $request){
		$customerName = $request->get('customerName');
		$isCustomer = (int)($request->get('type','Customer') == 'Customer') ;
		$isSupplier = (int)($request->get('type','Customer') == 'Supplier')  ;
		$isExist = Partner::where('is_customer',$isCustomer)->where('is_supplier',$isSupplier)->where('name',$customerName)->where('company_id',$company->id)->exists();
		if($isExist){
			return response()->json([
				'status'=>false ,
				'message'=>__('This Customer Already Exist')
			]);
		}
		$partner = Partner::create([
			'name'=>$customerName ,
			'is_customer'=>$isCustomer ,
			'is_supplier'=>$isSupplier ,
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
