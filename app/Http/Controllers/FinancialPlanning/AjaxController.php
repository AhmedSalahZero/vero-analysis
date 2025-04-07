<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Study;
use Illuminate\Http\Request;


class AjaxController extends Controller
{
	public function getStreamCategoryBasedOnRevenueStream(Request $request,Company $company,Study $study)
	{
		$revenueStreams = $request->get('revenueStreams',[]);
		if(count($revenueStreams) > 1){
			return response()->json([
				'is_all'=>true ,
				'result'=>[
				
				]
			]);
		}
		$relationName = [
			'has_leasing'=>'leasingRevenueStreamBreakdown',
			'has_direct_factoring'=>'directFactoringBreakdowns'
		];
		$result = [];
		foreach($revenueStreams as $currentRevenueType){
			$currentRelationName = $relationName[$currentRevenueType];
			$relation = $study->{$currentRelationName} ;
			$currentRevenues = $currentRelationName == 'leasingRevenueStreamBreakdown'  ?  $relation->pluck('category.title','category.id')->toArray() :$relation->pluck('category','category')->toArray();
			foreach($currentRevenues as $id => $title){
				if(is_numeric($title)){
					$title = $title . ' ' . __('Days');
				}
				$result[$id] = $title;
			}
			
		}
		
		return response()->json([
			'is_all'=>false,
			'result'=>$result
		]);
		
	}
	
}
