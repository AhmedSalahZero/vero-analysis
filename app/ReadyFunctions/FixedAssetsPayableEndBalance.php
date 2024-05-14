<?php 
namespace App\ReadyFunctions;

use App\Models\HospitalitySector;

class FixedAssetsPayableEndBalance  
{
	
	public function calculateEndBalance(array $purchase , array $collection , array $dateIndexWithDate,HospitalitySector $hospitalitySector )
	{
		// dd('land',$purchase);
		$purchasesForIntervals = [
			'monthly'=>$purchase,
			'quarterly'=>sumIntervals($purchase,'quarterly' , $hospitalitySector->financialYearStartMonth(),$dateIndexWithDate),
			'semi-annually'=>sumIntervals($purchase,'semi-annually' , $hospitalitySector->financialYearStartMonth(),$dateIndexWithDate),
			'annually'=>sumIntervals($purchase,'annually' , $hospitalitySector->financialYearStartMonth(),$dateIndexWithDate),
		];
		
		$collectionForInterval = [
			'monthly'=>$collection,
			'quarterly'=>sumIntervals($collection,'quarterly' , $hospitalitySector->financialYearStartMonth(),$dateIndexWithDate),
			'semi-annually'=>sumIntervals($collection,'semi-annually' , $hospitalitySector->financialYearStartMonth(),$dateIndexWithDate),
			'annually'=>sumIntervals($collection,'annually' , $hospitalitySector->financialYearStartMonth(),$dateIndexWithDate),
		];
		
		
		
		$result = [];
		$beginning_balances =[];
		$dueAmounts =[];
		$end_balance =[];
		foreach(getIntervalFormatted() as $intervalName=>$intervalNameFormatted){
			$beginning_balance = 0 ;
			foreach ($purchasesForIntervals[$intervalName]  as $dateAsIndex=>$purchaseAtDate) {
				$result[$intervalName]['beginning_balance'][$dateAsIndex] = $beginning_balance ; 
				$beginning_balances[$dateAsIndex] = $beginning_balance ;
				$result[$intervalName]['asset_purchases'][$dateAsIndex] = $purchaseAtDate ?? 0 ; 
				$due_amount =($purchaseAtDate??0) + $beginning_balance ;
				$result[$intervalName]['due_amount'][$dateAsIndex] = $due_amount ; 
				$currenPayment = getValueFromArrayStringAndIndex($collectionForInterval[$intervalName],$dateAsIndex,$dateAsIndex,0);
				$dueAmounts[$dateAsIndex] = $due_amount ;
				$end_balance[$dateAsIndex] = $due_amount - $currenPayment;
				$result[$intervalName]['payment'][$dateAsIndex] = $currenPayment ; 
				$result[$intervalName]['end_balance'][$dateAsIndex] = $end_balance[$dateAsIndex]??0 ; 
				$beginning_balance = $end_balance[$dateAsIndex];
			}
		
		}
		return $result ;
	}
	

}
