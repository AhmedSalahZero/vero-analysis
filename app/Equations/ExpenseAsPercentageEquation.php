<?php 
namespace App\Equations;

use App\Helpers\HArr;
use App\Helpers\HStr;
use App\Models\NonBankingService\Study;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ExpenseAsPercentageEquation
{
	public function calculate(int $studyId,string $percentageOf,array $revenueStreamType,array $streamCategoryIds,int $startDateAsIndex,int $endDateAsIndex,float $monthlyRate,string $paymentTermType,float $vatRate,bool $isDeductible,float $withholdTaxRate,bool $isSensitivity = false):array 
	{
		$hasLeasing = in_array('has_leasing',$revenueStreamType) ;
		$hasIjara = in_array('has_ijara_mortgage',$revenueStreamType) ; 
		$hasReverseFactoring = in_array('has_reverse_factoring',$revenueStreamType) ;
		$hasPortfolioMortgage = in_array('has_portfolio_mortgage',$revenueStreamType) ;
		$hasDirectFactoring = in_array('has_direct_factoring',$revenueStreamType) ;
		$dates = range($startDateAsIndex,$endDateAsIndex);
		$categoryIds = in_array('all',$streamCategoryIds) ? [] : $streamCategoryIds; 
		$resultArrs = [];
		$result = [];
		$selectedRevenueStreamTypes = [];
		$revenueStreamTypesWheres = [];
				if($hasLeasing){
					$selectedRevenueStreamTypes[] = Study::LEASING;
					$revenueStreamTypesWheres[] = ['leasing_breakdown_id','>',0];
				}
				if($hasIjara){
					$selectedRevenueStreamTypes[] = Study::IJARA;
					$revenueStreamTypesWheres[] = ['ijara_breakdown_id','>',0];
				}
				if($hasReverseFactoring){
					$selectedRevenueStreamTypes[] = Study::REVERSE_FACTORING;
					$revenueStreamTypesWheres[] = ['reverse_breakdown_id','>',0];
				}
				if($hasPortfolioMortgage){
					$selectedRevenueStreamTypes[] = Study::PORTFOLIO_MORTGAGE;
					dd('where is portfolio mortage monthly loan column ');
					// $revenueStreamType[] = ['reverse_breakdown_id','>',0];
				}
				if($hasDirectFactoring){
					$selectedRevenueStreamTypes[] = Study::DIRECT_FACTORING;
					$revenueStreamTypesWheres[] = ['direct_breakdown_id','>',0];
				}
				$revenueStreamTypesWheres = HStr::generateWhereFromMultipleArrs($revenueStreamTypesWheres,'OR');
				
		$loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments':'loan_schedule_payments';
		$vats = [];
		$withholds = [];
		if($percentageOf == 'contract'){
			$resultArrs = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('revenue_contracts')
			->where('study_id',$studyId)
			->when(count($categoryIds),function(Builder $builder) use ($categoryIds){
				$builder->whereIn('category_id',$categoryIds);
			})
			->whereRaw($revenueStreamTypesWheres)->pluck('monthly_loan_amounts')->map(function($item){
				return (array)json_decode($item);
			})->toArray();
		}
		else{
			if($hasLeasing || $hasIjara || $hasReverseFactoring ){
			$calculationColumn = [
				'revenue'=>'interestAmount',
				'outstanding'=>'endBalance',
				'collection'=>'schedulePayment'
			][$percentageOf];
			
			
			$resultArrs = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table($loanSchedulePaymentTableName)
			->whereIn('revenue_stream_type',$selectedRevenueStreamTypes)
			->where('study_id',$studyId)
			->where('portfolio_loan_type','portfolio')
			->when(count($categoryIds),function(Builder $builder) use ($categoryIds){
				$builder->whereIn('revenue_stream_category_id',$categoryIds);
			})->pluck($calculationColumn)->map(function($item){
				return (array)json_decode($item);
			})->toArray();
	

			
	
		}
		if($hasDirectFactoring){
			$calculationColumn = [
				'revenue'=>'interest_revenue',
				'outstanding'=>'end_balance',
				'collection'=>'direct_factoring_settlements',
				'contract'=>'direct_factoring_amounts'
			][$percentageOf];
			$categoryIds = in_array('all',$streamCategoryIds) ? [] : $streamCategoryIds; 
			$directFactoringAmounts = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('direct_factoring_breakdowns')
			->where('study_id',$studyId)
			->when(count($categoryIds),function(Builder $builder) use ($categoryIds){
				$builder->whereIn('category',$categoryIds);
			})->pluck($calculationColumn)->map(function($item){
				return (array)json_decode($item);
			})->toArray();
	
		

			foreach($directFactoringAmounts as $directFactoringAmount){
				foreach($directFactoringAmount as $monthIndex => $val){
					$valBeforeRate = $monthlyRate / 100 * $val ;
					$valueAfterVat =  0;
					if(!$isDeductible){
						$valueAfterVat = $valBeforeRate * (1+($vatRate/100));
					}
					$result['has_direct_factoring'][$monthIndex] = isset($result['has_direct_factoring'][$monthIndex]) ? $result['has_direct_factoring'][$monthIndex] + $valBeforeRate : $valBeforeRate ; 
					$onlyVatValue = $valueAfterVat -$valBeforeRate ; 
					$withholdValue = $withholdTaxRate / 100 * $valBeforeRate ;  
					 $vats['has_direct_factoring'][$monthIndex] = isset($vats['has_direct_factoring'][$monthIndex]) ? $vats['has_direct_factoring'][$monthIndex] + $onlyVatValue : $onlyVatValue; 
					 $withholds['has_direct_factoring'][$monthIndex] = isset($withholds['has_direct_factoring'][$monthIndex]) ? $withholds['has_direct_factoring'][$monthIndex] + $withholdValue : $withholdValue; 
				}
			}
	
		}
		}
		
		
		foreach($resultArrs as $resultArrItem){
				foreach($resultArrItem as $monthIndex => $val){
					$valBeforeRate = $monthlyRate / 100 * $val ;
					$valueAfterVat =  0;
					if(!$isDeductible){
						$valueAfterVat = $valBeforeRate * (1+($vatRate/100));
					}
					/**
					 * ! Is This Const Key [has_leasing] is true ?
					 */
					$result['has_leasing'][$monthIndex] = isset($result['has_leasing'][$monthIndex]) ? $result['has_leasing'][$monthIndex] + $valBeforeRate : $valBeforeRate ; 
					$onlyVatValue = $valueAfterVat -$valBeforeRate ; 
					$withholdValue = $withholdTaxRate / 100 * $valBeforeRate ; 
					 $vats['has_leasing'][$monthIndex] = isset($vats['has_leasing'][$monthIndex]) ? $vats['has_leasing'][$monthIndex] + $onlyVatValue : $onlyVatValue; 
					 $withholds['has_leasing'][$monthIndex] = isset($withholds['has_leasing'][$monthIndex]) ? $withholds['has_leasing'][$monthIndex] + $withholdValue : $withholdValue; 
					 /**
					  * ! End Question 
					  */
				}
			}
			
		$totalWithoutVat = [];
		foreach($result as $type => $arrItems){
			foreach($arrItems as $monthIndex=>$value){
				if($monthIndex>= $startDateAsIndex && $monthIndex <= $endDateAsIndex){
					$totalWithoutVat[$monthIndex] = isset($totalWithoutVat[$monthIndex]) ? $totalWithoutVat[$monthIndex] + $value : $value;
				}
			}
		}
		$totalVat = [];
		foreach($vats as $type => $arrItems){
			foreach($arrItems as $monthIndex=>$value){
				if($monthIndex>= $startDateAsIndex && $monthIndex <= $endDateAsIndex){
					$totalVat[$monthIndex] = isset($totalVat[$monthIndex]) ? $totalVat[$monthIndex] + $value : $value;
				}
			}
		}
		
		$totalWithhold = [];
		foreach($withholds as $type => $arrItems){
			foreach($arrItems as $monthIndex=>$value){
				if($monthIndex>= $startDateAsIndex && $monthIndex <= $endDateAsIndex){
					$totalWithhold[$monthIndex] = isset($totalWithhold[$monthIndex]) ? $totalWithhold[$monthIndex] + $value : $value;
				}
			}
		}

		return [
			'total_withhold'=>$totalWithhold , 
			'total_before_vat'=>$totalWithoutVat ,
			'total_vat'=>$totalVat,
			'total_after_vat'=>HArr::sumAtDates([$totalWithoutVat,$totalVat],$dates)
		];
	}
}
