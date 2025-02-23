<?php 
namespace App\Equations;
class OneTimeExpenseEquation
{
	public function calculate(float $amount,int $startDateAsIndex,bool $isDeductible,float $vatRate):array 
	{

		$payload = [];
		$amount = ($isDeductible ? $amount : $amount  * (1+($vatRate / 100))) / 12;
		for($i =  0 ; $i<12 ; $i++){
			$payload[$startDateAsIndex+$i] = $amount;
 		}
		return $payload;
	
	}
}
