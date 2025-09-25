<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Position;
use App\Models\NonBankingService\Study;
use Illuminate\Http\Request;


class AjaxController extends Controller
{
	// public function getStreamCategoryBasedOnRevenueStream(Request $request,Company $company,Study $study)
	// {
	// 	$revenueStreams = $request->get('revenueStreams',[]);
	// 	if(count($revenueStreams) > 1){
	// 		return response()->json([
	// 			'is_all'=>true ,
	// 			'result'=>[]
	// 		]);
	// 	}
	// 	$relationName = [
	// 		'has_leasing'=>'leasingRevenueStreamBreakdown',
	// 		'has_direct_factoring'=>'directFactoringBreakdowns',
	// 		'has_reverse_factoring'=>'reverseFactoringBreakdowns',
	// 		'has_ijara_mortgage'=>'ijaraMortgageBreakdowns',
	// 		'has_portfolio_mortgage'=>'portfolioMortgageRevenueProjectionByCategories'
	// 	];
	// 	$result = [];
	// 	foreach($revenueStreams as $currentRevenueType){
	// 		$currentRelationName = $relationName[$currentRevenueType];
	// 		$relation = $study->{$currentRelationName} ;
	// 		$titleColumnName = 'category';
	// 		$idColumnName = 'category';
	// 		$idAndTitleColumnNames = [
	// 			'leasingRevenueStreamBreakdown'=>[
	// 				'id'=>'category.id',
	// 				'title'=>'category.title'
	// 			],
	// 			'portfolioMortgageRevenueProjectionByCategories'=>[
	// 				'id'=>'portfolio_mortgage_duration',
	// 				'title'=>'portfolio_mortgage_duration'
	// 			]
	// 		][$currentRelationName]??[];
	// 		$id = $idAndTitleColumnNames['id']??$idColumnName;
	// 		$title = $idAndTitleColumnNames['title']??$titleColumnName;
	// 		$currentRevenues =  $relation->pluck($title,$id)->toArray();
	// 		foreach($currentRevenues as $id => $title){
	// 			if(is_numeric($title)){
	// 				$dayOrYears = $currentRevenueType == 'has_portfolio_mortgage' ? __('Years') :  __('Days') ;
	// 				$title = $title . ' ' . $dayOrYears;
	// 			}
	// 			$result[$id] = $title;
	// 		}
			
	// 	}
		
	// 	return response()->json([
	// 		'is_all'=>false,
	// 		'result'=>$result
	// 	]);
		
	// }
	public function getPositionsBasedOnDepartments(Request $request)
	{
		$departmentIds = $request->get('departmentIds',[]);
		$positionIds = Position::whereIn('department_id',$departmentIds)->pluck('name','id')->toArray();
		return response()->json([
			'positionIds'=>$positionIds			
		]);
	}
	
}
