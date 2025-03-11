<?php 
namespace App\ReadyFunctions;

use App\Models\NonBankingService\FixedAsset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class FixedAssetCalculation
{
	public function __calculate(Collection $fixedAssets,array $dateIndexWithDate,string $operationStartDateFormatted ,array $studyDates , string $studyEndDate)
	{
		// $fixedAssets
			/**
			 * *
			 $operationStartDateFormatted = $study->getOperationStartDateFormatted();
			 */
			$ffeAssetItems = $this->calculateFFEAssetsForFFE($fixedAssets,$dateIndexWithDate,$operationStartDateFormatted,$studyDates,$studyEndDate);
			$totalOfFFEItemForFFE = $this->findTotalOfFFEFixedAssets($ffeAssetItems ,$studyDates);
		
	}
	protected function findTotalOfFFEFixedAssets(array $ffeAsset,array $studyDates ){
		$total = [];
		$initialTotalGross = array_column($ffeAsset,'initial_total_gross');
		$finalTotalGross = array_column($ffeAsset,'final_total_gross');
		$finalTotalAccumulated = array_column($ffeAsset,'accumulated_depreciation');
		$finalTotalOfEndBalance = array_column($ffeAsset,'end_balance');
		$finalTotalOfTotalDepreciation = array_column($ffeAsset,'total_monthly_depreciation');

		$finalTotalOfReplacementCost = array_column($ffeAsset,'replacement_cost');

		$finalTotalGrossCount = count($finalTotalGross);
		foreach($studyDates as $dateAsString=>$dateAsIndex){
			$currenTotal = 0 ;
			$currenAccumulatedDepreciationTotal = 0 ;
			$currentTotalOfEndBalance = 0 ;
			$currentTotalOfInitialGross = 0 ;
			$currentTotalOfTotalDepreciation = 0 ;
			$currentTotalOfReplacementCost = 0 ;
			for($i = 0 ; $i< $finalTotalGrossCount ; $i++){
				$currenTotal+=$finalTotalGross[$i][$dateAsString]??0;
				$currentTotalOfInitialGross+=$initialTotalGross[$i][$dateAsString]??0;
				$currenAccumulatedDepreciationTotal+=$finalTotalAccumulated[$i][$dateAsString]??0;
				$currentTotalOfEndBalance+=$finalTotalOfEndBalance[$i][$dateAsString]??0;
				$currentTotalOfTotalDepreciation+=$finalTotalOfTotalDepreciation[$i][$dateAsString]??0;
				$currentTotalOfReplacementCost+=$finalTotalOfReplacementCost[$i][$dateAsString]??0;
			}
			$total['initial_total_gross'][$dateAsIndex] = $currentTotalOfInitialGross;
			$total['final_total_gross'][$dateAsIndex] = $currenTotal;
			$total['accumulated_depreciation'][$dateAsIndex] = $currenAccumulatedDepreciationTotal;
			$total['end_balance'][$dateAsIndex] = $currentTotalOfEndBalance;
			$total['total_monthly_depreciation'][$dateAsIndex] = $currentTotalOfTotalDepreciation;
			$total['replacement_cost'][$dateAsIndex] = $currentTotalOfReplacementCost;
		}

		return $total ;
	}
	public function getTotalItemsCost(Collection $ffeItems):float 
	{
		
		$total = 0;
		$ffeItems->each(function($ffeItem) use (&$total){
			$total += $ffeItem->getItemCost() * (1+($ffeItem->getContingencyRate()/100));
		});
	
		return $total ; 
	}	
	public function calculateFFEAssetsForFFE(Collection $fixedAssetItems , array $dateIndexWithDate ,string $operationStartDateFormatted ,array $studyDates,string $studyEndDate):array 
	{
		$studyDates = array_flip($studyDates);
		$assets = [];
	
		$totalItemsCost = $this->getTotalItemsCost($fixedAssetItems);
		$fixedAssetItems->each(function(FixedAsset $ffeItem) use ($dateIndexWithDate,$operationStartDateFormatted,$totalItemsCost,&$assets,$studyDates,$studyEndDate){
			$depreciationDurationInMonthsForFFE = $ffeItem->getDepreciationDurationInMonths();
			$ffeReplacementCostRateForFFE = $ffeItem->getReplacementCostRate()  ;
			$ffeReplacementIntervalInMonthsForFFE = $ffeItem->getReplacementIntervalInMonths();
			$totalCost = $ffeItem->getTotalCost();
			$fixedAssetItemPurchaseDates = $ffeItem->getPurchaseDates($dateIndexWithDate);
			foreach($fixedAssetItemPurchaseDates as $purchaseDateASIndex => $purchaseDateAsString){
				$transferredAmount = $ffeItem->getMonthlyAmountAtMonthIndex($purchaseDateASIndex);
			$ffeItemTransferredAmount = $totalItemsCost ? $transferredAmount*($totalCost / $totalItemsCost) : 0  ;
			$projectUnderProgressForFFE = [
				'purchase_date_and_vales'=>[
					$purchaseDateAsString =>  $ffeItemTransferredAmount,
				]
			];
			$assets[$ffeItem->getName()][$purchaseDateASIndex] = $this->calculateFFEAssets($operationStartDateFormatted,$depreciationDurationInMonthsForFFE,$ffeReplacementCostRateForFFE,$ffeReplacementIntervalInMonthsForFFE,$projectUnderProgressForFFE,$studyDates,$studyEndDate);
		
			}
			
			});
		dd('good',$assets);
		return $assets ;
	  
	}
	public function calculateFFEAssets(string $operationStartDateFormatted,int $propertyDepreciationDurationInMonths,float $propertyReplacementCostRate,int $propertyReplacementIntervalInMonths,array $projectUnderProgressForConstruction,array $studyDates,string $studyEndDate ):array 
	{
		$buildingAssets = [];
		// $hospitalitySector = $this->hospitalitySector?:$hospitalitySector;
		// $operationStartDateFormatted = $study->getOperationStartDateFormatted();
		$propertyReplacementCostRate = $propertyReplacementCostRate /100;
		$purchaseDateAsStringAndValue = $projectUnderProgressForConstruction['purchase_date_and_vales']??[];
		$purchaseDateAsString = array_key_last($purchaseDateAsStringAndValue);
		// $constructionTransferredDate = array_key_last($constructionTransferredDateAndValue);
		$constructionTransferredValue = $purchaseDateAsStringAndValue[$purchaseDateAsString]??0;

		$beginningBalance = 0;
		$totalMonthlyDepreciation = [];
		$accumulatedDepreciation = [];
		$replacementDates = $this->calculateReplacementDates($studyDates,$operationStartDateFormatted ,$studyEndDate,$propertyReplacementIntervalInMonths);
		$depreciation = [];
		$index = 0 ;
		$depreciationStartDate = null;
		
		foreach ($studyDates as $dateAsString => $dateAsIndex) {
			if(Carbon::make($purchaseDateAsString)->lessThan($operationStartDateFormatted)){
			// if(Carbon::make($constructionTransferredDate)->lessThan($operationStartDateFormatted)){
			$depreciationStartDate = $operationStartDateFormatted;
		}else{
				$depreciationStartDate = getNextDate($studyDates,$dateAsString);
			}
			$depreciationEndDate = $depreciationStartDate ? Carbon::make($depreciationStartDate)->addMonths($propertyDepreciationDurationInMonths - 1) : null;
			$buildingAssets['beginning_balance'][$dateAsString]= $beginningBalance;
			// dd($purchaseDateAsString ,$constructionTransferredValue );
			$buildingAssets['additions'][$dateAsString]=  $dateAsString ==$purchaseDateAsString ? $constructionTransferredValue : 0;
			// dd($buildingAssets);
			// $buildingAssets['additions'][$dateAsString]=  $dateAsString ==$constructionTransferredDate ? $constructionTransferredValue : 0;
			// $buildingAssets['initial_total_gross'][$dateAsString] =    $beginningBalance;
			$buildingAssets['initial_total_gross'][$dateAsString] =  $buildingAssets['additions'][$dateAsString] +  $beginningBalance;
			$currentInitialTotalGross = $buildingAssets['initial_total_gross'][$dateAsString] ??0;
			$replacementCost[$dateAsString] =    in_array($dateAsString ,$replacementDates)  ? $this->calculateReplacementCost($currentInitialTotalGross,$propertyReplacementCostRate) : 0;
			// dd($replacementDates , $dateAsString,in_array($dateAsString ,$replacementDates) );
			if( in_array($dateAsString ,$replacementDates) 
			// && ( Carbon::make($constructionTransferredDate)->lessThan($operationStartDateFormatted))
		){
				$depreciationStartDate = getNextDate($studyDates,$dateAsString);
				// dd($propertyDepreciationDurationInMonths);
				$depreciationEndDate = $depreciationStartDate ? Carbon::make($depreciationStartDate)->addMonths($propertyDepreciationDurationInMonths - 1) : null;
			}
			$replacementValueAtCurrentDate = $replacementCost[$dateAsString] ?? 0;
		
			$buildingAssets['replacement_cost'][$dateAsString] = $replacementCost[$dateAsString] ;
			$buildingAssets['final_total_gross'][$dateAsString] = $buildingAssets['initial_total_gross'][$dateAsString]  + $replacementValueAtCurrentDate;
			$depreciation[$dateAsString]=$this->calculateMonthlyDepreciation($buildingAssets['additions'][$dateAsString]??0,$replacementValueAtCurrentDate,$propertyDepreciationDurationInMonths, $depreciationStartDate, $depreciationEndDate, $totalMonthlyDepreciation, $accumulatedDepreciation,$studyDates);
			$accumulatedDepreciation = $this->calculateAccumulatedDepreciation($totalMonthlyDepreciation,$studyDates);
			$buildingAssets['total_monthly_depreciation'] =$totalMonthlyDepreciation;
			$buildingAssets['accumulated_depreciation'] =$accumulatedDepreciation;
			$currentAccumulatedDepreciation = $buildingAssets['accumulated_depreciation'][$dateAsString] ?? 0;
			$buildingAssets['end_balance'][$dateAsString] =  $buildingAssets['final_total_gross'][$dateAsString] -  $currentAccumulatedDepreciation;
			$beginningBalance = $buildingAssets['final_total_gross'][$dateAsString];
			$index++;
		}
		
		return $buildingAssets ;
	}
	protected function calculateMonthlyDepreciation(float $additions,float $replacementCost,int $propertyDepreciationDurationInMonths, ?string $depreciationStartDate, ?string $depreciationEndDate, &$totalMonthlyDepreciation, &$accumulatedDepreciation,array $studyDates)
	{
		if (!$depreciationStartDate || !$depreciationEndDate) {
			return [];
		}
		$monthlyDepreciations = [];
		$monthlyDepreciationAtCurrentDate =  ($additions+$replacementCost) / $propertyDepreciationDurationInMonths ;
		$depreciationStartDateAsCarbon = Carbon::make($depreciationStartDate);
		$depreciationEndDateAsCarbon = Carbon::make($depreciationEndDate);
		$depreciationDates = generateDatesBetweenTwoDates($depreciationStartDateAsCarbon, $depreciationEndDateAsCarbon, 'addMonth', 'Y-m-d');
		foreach ($studyDates as $dateAsString => $dateAsIndex) {
			$previousDate = getPreviousDate($studyDates, $dateAsString);
			if(in_array($dateAsString,$depreciationDates)){
				$monthlyDepreciations[$dateAsString] = $monthlyDepreciationAtCurrentDate;
				$totalMonthlyDepreciation[$dateAsString] = isset($totalMonthlyDepreciation[$dateAsString]) ? $totalMonthlyDepreciation[$dateAsString] +$monthlyDepreciationAtCurrentDate : $monthlyDepreciationAtCurrentDate;
				$accumulatedDepreciation[$dateAsString] = $previousDate ? ($totalMonthlyDepreciation[$dateAsString] + $accumulatedDepreciation[$previousDate]) : $totalMonthlyDepreciation[$dateAsString];
			}else{
				// $monthlyDepreciations[$dateAsString] = 0;
				// $totalMonthlyDepreciation[$dateAsString]  = 0 ;
				$accumulatedDepreciation[$dateAsString] = $accumulatedDepreciation[$previousDate] ?? 0 ;
			}
		}

		return $monthlyDepreciations;
	}
	protected function calculateAccumulatedDepreciation(array $totalMonthlyDepreciation,array $studyDates)
	{
		$result = [];
		foreach ($studyDates  as $date=>$dateIndex) {
			$value = $totalMonthlyDepreciation[$date] ?? 0; 
			$previousDate = getPreviousDate($studyDates, $date);
			$result[$date] = $previousDate ? $result[$previousDate] + $value : $value;
		}

		return $result;
	}
	protected function calculateReplacementCost(float $totalGross, float $propertyReplacementCostRate  )
	{
		return $totalGross * $propertyReplacementCostRate ;
	}
	protected function calculateReplacementDates(array $studyDates , string $operationStartDateFormatted , string $studyEndDate ,int $propertyReplacementIntervalInMonths,$debug=false)
	{
		$replacementDates = [];
		foreach($studyDates as $studyDateAsString=>$studyDateAsIndex){
			if(Carbon::make($operationStartDateFormatted) > Carbon::make($studyEndDate)){
				break ;	
			}
			$replacementDates[$studyDateAsString] = Carbon::make($operationStartDateFormatted)->addMonths($propertyReplacementIntervalInMonths)->format('Y-m-d');
			$operationStartDateFormatted = $replacementDates[$studyDateAsString] ;
		}
		return $replacementDates ;
	}	
	
	
	
}
