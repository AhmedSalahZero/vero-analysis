<?php 
namespace App\Equations;

use App\Helpers\HArr;

class MonthlyFixedRepeatingAmountEquation
{
	public function calculate(float $amount,int $startDateAsIndex,int $endDateAsIndex,string $increaseInterval, $increaseRate,bool $isDeductible,float $vatRate,float $withholdRate,$dateIndexWithYearIndex = [] , $contractCount = null , $numberOfBranches = 1  ):array 
	{
		$resultWithoutVat = [];
		$resultWithVat = [];
		$resultVat = [];
		$currentStartDateAsIndex = $startDateAsIndex ;
		$intervalMode = [
			'quarterly'=> 3 ,
			'semi-annually'=>6,
			'annually'=>12
		][$increaseInterval];
		$counter = 0 ;
		
		// $vat = $amountAfterVat - $amountBeforeVat;
		for($currentStartDateAsIndex ; $currentStartDateAsIndex <= $endDateAsIndex ; $currentStartDateAsIndex++ ){
			// $currentCount = 1 ; 
			// if(is_array($contractCount)){
			// 	$currentCount = $contractCount[$currentStartDateAsIndex]??0;
			// }
			// $amountBeforeVat = $amount*$currentCount * $numberOfBranches ; 
			// $amountAfterVat = $isDeductible ? $amountBeforeVat : $amountBeforeVat  * (1+($vatRate / 100));
			$currentIncreaseRate = 0;
			// dd(if());
			if($counter!=0&&$counter % $intervalMode == 0){
				// logger('increase here' . $counter);
				// $amountBeforeVat = ;
				$currentIncreaseRate = is_array($increaseRate) ? $increaseRate[$dateIndexWithYearIndex[$currentStartDateAsIndex]-1]??0 : $increaseRate ;
				// dd($currentIncreaseRate);
				// $resultWithoutVat[$currentStartDateAsIndex] =$resultWithoutVat[$currentStartDateAsIndex-1] * (1+$currentIncreaseRate/100)   ; 
				// $withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100  ;
				// $resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1] * (1+$currentIncreaseRate/100) ; 
				// $resultVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex] - $resultWithoutVat[$currentStartDateAsIndex]  ;
			}
			// else{
				// if(!isset($resultWithoutVat[$currentStartDateAsIndex-1])){
				// 	logger('not found');
				// 	$resultWithoutVat[$currentStartDateAsIndex] = $amountBeforeVat  ;
				// 	$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100  ;
				// 	$resultWithVat[$currentStartDateAsIndex] = $amountAfterVat  ;
				// 	$resultVat[$currentStartDateAsIndex] = ($amountAfterVat - $amountBeforeVat ) ;
				// }else{
					$currentIncreaseRate  = (1+$currentIncreaseRate/100) ;
					$amountBeforeVat = $currentIncreaseRate  * ($resultWithoutVat[$currentStartDateAsIndex-1]??$amount);
					$resultWithoutVat[$currentStartDateAsIndex] = $amountBeforeVat  ; 
					$withholdAmounts[$currentStartDateAsIndex]=$amountBeforeVat * $withholdRate / 100  ;
					$resultWithVat[$currentStartDateAsIndex] = $amountBeforeVat *   (1+($vatRate / 100)) ; 
					$resultVat[$currentStartDateAsIndex] = ($resultWithVat[$currentStartDateAsIndex] - $amountBeforeVat) ;
				// }
			// }
			$counter++;
		}
		// $contractCount = [2,4,6,8,10,12,14,16,18];
		if(is_array($contractCount)){
			$withholdAmounts = HArr::multipleTwoArrAtSameIndex($withholdAmounts , $contractCount );
			$resultWithoutVat = HArr::multipleTwoArrAtSameIndex($resultWithoutVat , $contractCount );
			$resultVat = HArr::multipleTwoArrAtSameIndex($resultVat , $contractCount );
			$resultWithVat = HArr::multipleTwoArrAtSameIndex($resultWithVat , $contractCount );
		}
		if($numberOfBranches > 1 ){
			$withholdAmounts = HArr::MultiplyWithNumber($withholdAmounts , $numberOfBranches );
			$resultWithoutVat = HArr::MultiplyWithNumber($resultWithoutVat , $numberOfBranches );
			$resultVat = HArr::MultiplyWithNumber($resultVat , $numberOfBranches );
			$resultWithVat = HArr::MultiplyWithNumber($resultWithVat , $numberOfBranches );
		}
		// dd($withholdAmounts);
		// if(is_array($increaseRate)){
		// 		dd([
		// 	'withhold_amounts'=>$withholdAmounts , 
		// 	'total_before_vat'=>$resultWithoutVat,
		// 	'total_vat'=>$resultVat,
		// 	'total_after_vat'=>$resultWithVat
		// ]);
		// 	}
			// foreach()
		return [
			'withhold_amounts'=>$withholdAmounts , 
			'total_before_vat'=>$resultWithoutVat,
			'total_vat'=>$resultVat,
			'total_after_vat'=>$resultWithVat
		];
	
	}
}
