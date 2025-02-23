<?php 
namespace App\Equations;

use App\Models\NonBankingService\Study;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ExpenseAsPercentageEquation
{
	public function calculate(int $studyId,string $percentageOf,array $revenueStreamType,array $streamCategoryIds,int $startDateAsIndex,int $endDateAsIndex,float $monthlyRate,string $paymentTermType,float $vatRate,bool $isDeductible,float $withholdTaxRate):array 
	{
		$result = [];
		if(in_array('has_leasing',$revenueStreamType) || in_array('has_ijara_mortgage',$revenueStreamType) || in_array('has_reverse_factoring',$revenueStreamType) ){
			$calculationColumn = [
				'revenue'=>'interestAmount',
				'outstanding'=>'endBalance',
				'collection'=>'schedulePayment',
				// 'contract'=>
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
			$leasingLoans = DB::connection('non_banking_service')->table('loan_schedule_payments')
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
					$val = $monthlyRate / 100 * $val ;
					if(!$isDeductible){
						$val = $val * (1+($vatRate/100));
					}
					$result['has_leasing'][$monthIndex] = isset($result['has_leasing'][$monthIndex]) ? $result['has_leasing'][$monthIndex] + $val : $val ; 
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
					$val = $monthlyRate / 100 * $val ;
					if(!$isDeductible){
						$val = $val * (1+($vatRate/100));
					}
					$result['has_direct_factoring'][$monthIndex] = isset($result['has_direct_factoring'][$monthIndex]) ? $result['has_direct_factoring'][$monthIndex] + $val : $val ; 
				}
			}
	
		}
		$totals = [];
		foreach($result as $type => $arrItems){
			foreach($arrItems as $monthIndex=>$value){
				if($monthIndex>= $startDateAsIndex && $monthIndex <= $endDateAsIndex){
					$totals[$monthIndex] = isset($totals[$monthIndex]) ? $totals[$monthIndex] + $value : $value;
				}
			}
		}
		return $totals;
	}
}
