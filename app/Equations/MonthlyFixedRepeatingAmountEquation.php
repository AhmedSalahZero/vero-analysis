<?php 
namespace App\Equations;
class MonthlyFixedRepeatingAmountEquation
{
	public function calculate(float $amount,int $startDateAsIndex,int $endDateAsIndex,string $increaseInterval,float $increaseRate,bool $isDeductible,float $vatRate):array 
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
		$vat = $amountAfterVat - $amountBeforeVat;
		for($currentStartDateAsIndex ; $currentStartDateAsIndex <= $endDateAsIndex ; $currentStartDateAsIndex++ ){
			if($counter!=0&&$counter % $intervalMode == 0){
				$resultWithoutVat[$currentStartDateAsIndex] = $resultWithoutVat[$currentStartDateAsIndex-1] * (1+$increaseRate/100); 
				$resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1] * (1+$increaseRate/100); 
			}else{
				if(!isset($resultWithoutVat[$currentStartDateAsIndex-1])){
					$resultWithoutVat[$currentStartDateAsIndex] = $amountBeforeVat ;
					$resultWithVat[$currentStartDateAsIndex] = $amountAfterVat ;
					$resultVat[$currentStartDateAsIndex] = $amountAfterVat - $amountBeforeVat ;
				}else{
					$resultWithoutVat[$currentStartDateAsIndex] = $resultWithoutVat[$currentStartDateAsIndex-1] ; 
					$resultWithVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1] ; 
					$resultVat[$currentStartDateAsIndex] = $resultWithVat[$currentStartDateAsIndex-1] - $resultWithoutVat[$currentStartDateAsIndex-1] ;
				}
			}
			$counter++;
		}
		return [
			'total_before_vat'=>$resultWithoutVat,
			'total_vat'=>$resultVat,
			'total_after_vat'=>$resultWithVat
		];
	
	}
}
