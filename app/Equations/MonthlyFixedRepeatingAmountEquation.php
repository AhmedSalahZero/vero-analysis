<?php 
namespace App\Equations;
class MonthlyFixedRepeatingAmountEquation
{
	public function calculate(float $amount,int $startDateAsIndex,int $endDateAsIndex,string $increaseInterval,float $increaseRate,bool $isDeductible,float $vatRate):array 
	{
		$result = [];
		$currentStartDateAsIndex = $startDateAsIndex ;
		$intervalMode = [
			'quarterly'=> 3 ,
			'semi-annually'=>6,
			'annually'=>12
		][$increaseInterval];
		
		$counter = 0 ;
		$amount = $isDeductible ? $amount : $amount  * (1+($vatRate / 100));
		for($currentStartDateAsIndex ; $currentStartDateAsIndex <= $endDateAsIndex ; $currentStartDateAsIndex++ ){
			if($counter!=0&&$counter % $intervalMode == 0){
				$result[$currentStartDateAsIndex] = $result[$currentStartDateAsIndex-1] * (1+$increaseRate/100); 
			}else{
				if(!isset($result[$currentStartDateAsIndex-1])){
					$result[$currentStartDateAsIndex] = $amount ;
				}else{
					$result[$currentStartDateAsIndex] = $result[$currentStartDateAsIndex-1] ; 
					
				}
			}
			$counter++;
		}
		return $result;
	
	}
}
