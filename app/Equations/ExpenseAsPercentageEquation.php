<?php 
namespace App\Equations;

use App\Helpers\HArr;
use App\Models\NonBankingService\Study;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ExpenseAsPercentageEquation
{
	public function calculate(int $studyId,string $percentageOf,array $revenueStreamType,array $streamCategoryIds,int $startDateAsIndex,int $endDateAsIndex,float $monthlyRate,string $paymentTermType,float $vatRate,bool $isDeductible,float $withholdTaxRate,bool $isSensitivity = false):array 
	{
		$dates = range($startDateAsIndex,$endDateAsIndex);
		$loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments':'loan_schedule_payments';
		$result = [];
		$vats = [];
		$withholds = [];
		if(in_array('has_leasing',$revenueStreamType) || in_array('has_ijara_mortgage',$revenueStreamType) || in_array('has_reverse_factoring',$revenueStreamType) ){
			$calculationColumn = [
				'revenue'=>'interestAmount',
				'outstanding'=>'endBalance',
				'collection'=>'schedulePayment',
				'contract'=>
			][$percentageOf];
			$selectedRevenueStreamTypes = [];

				if(in_array('has_leasing',$revenueStreamType)){
					$selectedRevenueStreamTypes[] = Study::LEASING;
				}
				if(in_array('has_ijara_mortgage',$revenueStreamType)){
					$selectedRevenueStreamTypes[] = Study::IJARA;
				}
				if(in_array('has_reverse_factoring',$revenueStreamType)){
					$selectedRevenueStreamTypes[] = Study::REVERSE_FACTORING;
				}
			$categoryIds = in_array('all',$streamCategoryIds) ? [] : $streamCategoryIds; 
			$leasingLoans = DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)
			->whereIn('revenue_stream_type',$selectedRevenueStreamTypes)
			->where('study_id',$studyId)
			->where('portfolio_loan_type','portfolio')
			->when(count($categoryIds),function(Builder $builder) use ($categoryIds){
				$builder->whereIn('revenue_stream_category_id',$categoryIds);
			})->pluck($calculationColumn)->map(function($item){
				return (array)json_decode($item);
			})->toArray();
	

			foreach($leasingLoans as $leasingLoan){
				foreach($leasingLoan as $monthIndex => $val){
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
	
		}
		if(in_array('has_direct_factoring',$revenueStreamType)){
			$calculationColumn = [
				'revenue'=>'interest_revenue',
				'outstanding'=>'end_balance',
				'collection'=>'direct_factoring_settlements',
				'contract'=>'direct_factoring_amounts'
			][$percentageOf];
			$categoryIds = in_array('all',$streamCategoryIds) ? [] : $streamCategoryIds; 
			$directFactoringAmounts = DB::connection('non_banking_service')->table('direct_factoring_breakdowns')
			->where('study_id',$studyId)
			->when(count($categoryIds),function(Builder $builder) use ($categoryIds){
				$builder->whereIn('category',$categoryIds);
			})->pluck($calculationColumn)->map(function($item){
				return (array)json_decode($item);
			})->toArray();
	
		

			foreach($directFactoringAmounts as $directFactoringAmount){
				foreach($directFactoringAmount as $monthIndex => $val){
					$valueBeforeVat = $monthlyRate / 100 * $val ;
					$valueAfterVat =  0;
					if(!$isDeductible){
						$valueAfterVat = $valBeforeRate * (1+($vatRate/100));
					}
					$result['has_direct_factoring'][$monthIndex] = isset($result['has_direct_factoring'][$monthIndex]) ? $result['has_direct_factoring'][$monthIndex] + $valueBeforeVat : $valueBeforeVat ; 
					$onlyVatValue = $valueAfterVat -$valBeforeRate ; 
					$withholdValue = $withholdTaxRate / 100 * $valBeforeRate ;  
					 $vats['has_direct_factoring'][$monthIndex] = isset($vats['has_direct_factoring'][$monthIndex]) ? $vats['has_direct_factoring'][$monthIndex] + $onlyVatValue : $onlyVatValue; 
					 $withholds['has_direct_factoring'][$monthIndex] = isset($withholds['has_direct_factoring'][$monthIndex]) ? $withholds['has_direct_factoring'][$monthIndex] + $withholdValue : $withholdValue; 
				}
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
