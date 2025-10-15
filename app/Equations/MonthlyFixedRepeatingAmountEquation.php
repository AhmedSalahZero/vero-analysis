<?php 
namespace App\Equations;
class MonthlyFixedRepeatingAmountEquation
{
	public function calculate(float $amount,int $startDateAsIndex,int $endDateAsIndex,string $increaseInterval, $increaseRate,bool $isDeductible,float $vatRate,float $withholdRate,$dateIndexWithYearIndex = [] , $contractCount = null):array 
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
		$amountBeforeVat = $amount ; 
		$amountAfterVat = $isDeductible ? $amountBeforeVat : $amountBeforeVat  * (1+($vatRate / 100));
		// $vat = $amountAfterVat - $amountBeforeVat;
		for($currentStartDateAsIndex ; $currentStartDateAsIndex <= $endDateAsIndex ; $currentStartDateAsIndex++ ){
		
			$currentIncreaseRate = is_array($increaseRate) ? $increaseRate[$dateIndexWithYearIndex[$currentStartDateAsIndex]]??0 : $increaseRate ;
			$currentCount = 1 ; 
			if(is_array($contractCount)){
				$currentCount = $contractCount[$currentStartDateAsIndex]??0;
			}
			if($counter!=0&&$counter % $intervalMode == 0){
				$resultWithoutVat[$currentStartDateAsIndex] = $resultWithoutVat[$currentStartDateAsIndex-1] * (1+$currentIncreaseRate/100) * $currentCount ; 
				$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100 * $currentCount ;
				$resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1] * (1+$currentIncreaseRate/100) * $currentCount; 
				$resultVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex] - $resultWithoutVat[$currentStartDateAsIndex] * $currentCount ;
			}else{
				if(!isset($resultWithoutVat[$currentStartDateAsIndex-1])){
					$resultWithoutVat[$currentStartDateAsIndex] = $amountBeforeVat * $currentCount ;
					$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100 * $currentCount ;
					$resultWithVat[$currentStartDateAsIndex] = $amountAfterVat * $currentCount ;
					$resultVat[$currentStartDateAsIndex] = ($amountAfterVat - $amountBeforeVat ) * $currentCount;
				}else{
					$resultWithoutVat[$currentStartDateAsIndex] = $resultWithoutVat[$currentStartDateAsIndex-1] * $currentCount ; 
					$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100  * $currentCount;
					$resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1]  * $currentCount; 
					$resultVat[$currentStartDateAsIndex] = ($resultWithVat[$currentStartDateAsIndex-1] - $resultWithoutVat[$currentStartDateAsIndex-1]) * $currentCount ;
				}
			}
			$counter++;
		}
		return [
			'withhold_amounts'=>$withholdAmounts , 
			'total_before_vat'=>$resultWithoutVat,
			'total_vat'=>$resultVat,
			'total_after_vat'=>$resultWithVat
		];
	
	}
}
