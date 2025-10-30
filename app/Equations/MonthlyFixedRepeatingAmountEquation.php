<?php 
namespace App\Equations;
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
			$currentCount = 1 ; 
			if(is_array($contractCount)){
				$currentCount = $contractCount[$currentStartDateAsIndex]??0;
			}
			$amountBeforeVat = $amount*$currentCount * $numberOfBranches ; 
			$amountAfterVat = $isDeductible ? $amountBeforeVat : $amountBeforeVat  * (1+($vatRate / 100));
			$currentIncreaseRate = is_array($increaseRate) ? $increaseRate[$dateIndexWithYearIndex[$currentStartDateAsIndex]-1]??0 : $increaseRate ;
			if($counter!=0&&$counter % $intervalMode == 0){
				$resultWithoutVat[$currentStartDateAsIndex] = $resultWithoutVat[$currentStartDateAsIndex-1] * (1+$currentIncreaseRate/100)  ; 
				$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100  ;
				$resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1] * (1+$currentIncreaseRate/100) ; 
				$resultVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex] - $resultWithoutVat[$currentStartDateAsIndex]  ;
			}else{
				if(!isset($resultWithoutVat[$currentStartDateAsIndex-1])){
					$resultWithoutVat[$currentStartDateAsIndex] = $amountBeforeVat  ;
				
					$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100  ;
					$resultWithVat[$currentStartDateAsIndex] = $amountAfterVat  ;
					$resultVat[$currentStartDateAsIndex] = ($amountAfterVat - $amountBeforeVat ) ;
				}else{
					$resultWithoutVat[$currentStartDateAsIndex] = $amountBeforeVat  ; 
					// $resultWithoutVat[$currentStartDateAsIndex] = $resultWithoutVat[$currentStartDateAsIndex-1]  ; 
					$withholdAmounts[$currentStartDateAsIndex]=$resultWithoutVat[$currentStartDateAsIndex] * $withholdRate / 100  ;
					$resultWithVat[$currentStartDateAsIndex] = $amountAfterVat  ; 
					// $resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1]  ; 
					$resultVat[$currentStartDateAsIndex] = ($amountAfterVat - $amountBeforeVat) ;
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
