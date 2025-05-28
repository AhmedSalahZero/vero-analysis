<?php 
namespace App\ReadyFunctions;

use App\Models\NonBankingService\FixedAsset;
use App\Models\NonBankingService\FixedAssetStatement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FixedAssetCalculation
{
	public function __calculate(Collection $fixedAssets,array $dateIndexWithDate,int $operationStartDateAsIndex ,array $studyDates , int $studyEndDateAsIndex,int $studyId , int $companyId)
	{
		// $fixedAssets
			/**
			 * *
			 $operationStartDateFormatted = $study->getOperationStartDateFormatted();
			 */
			$studyDates = array_flip($studyDates);
			$ffeAssetItems = $this->calculateFFEAssetsForFFE($fixedAssets,$dateIndexWithDate,$operationStartDateAsIndex,$studyDates,$studyEndDateAsIndex);
			return $this->sumTotalPerRow($ffeAssetItems,$studyId,$companyId);
	}
	protected function sumTotalPerRow(array $ffeAssetItems,int $studyId,int $companyId):array
	{
		$finalResult =[];
		foreach($ffeAssetItems as $fixedAssetItemId => $fixedAssetResultArr){
			$finalResult[$fixedAssetItemId]['fixed_asset_id']=$fixedAssetItemId;
			$finalResult[$fixedAssetItemId]['study_id']=$studyId;
			$finalResult[$fixedAssetItemId]['company_id']=$companyId;
			foreach($fixedAssetResultArr as $currentIndex => $currentResultAsArr){
				foreach($currentResultAsArr as $typeName => $typeResult){
					foreach($typeResult as $dateAsIndex => $currentValue){
						$finalResult[$fixedAssetItemId][$typeName][$dateAsIndex] = isset($finalResult[$fixedAssetItemId][$typeName][$dateAsIndex]) ? $finalResult[$fixedAssetItemId][$typeName][$dateAsIndex] + $currentValue : $currentValue;
					}
				}
				// $finalResult[$fixedAssetItemId][$typeName] = json_encode($finalResult[$fixedAssetItemId][$typeName]);
			}
		}
		return $finalResult;
	}
	
	public function getTotalItemsCost(Collection $ffeItems):float 
	{
		
		$total = 0;
		$ffeItems->each(function($ffeItem) use (&$total){
			$total += $ffeItem->getItemCost() * (1+($ffeItem->getContingencyRate()/100));
		});
	
		return $total ; 
	}	
	public function calculateFFEAssetsForFFE(Collection $fixedAssetItems , array $dateIndexWithDate ,int $operationStartDateAsIndex ,array $studyDates,int $studyEndDateAsIndex):array 
	{
		
		$assets = [];
	
		$totalItemsCost = $this->getTotalItemsCost($fixedAssetItems);
		$fixedAssetItems->each(function(FixedAsset $ffeItem) use ($dateIndexWithDate,$operationStartDateAsIndex,$totalItemsCost,&$assets,$studyDates,$studyEndDateAsIndex){
			$depreciationDurationInMonthsForFFE = $ffeItem->getDepreciationDurationInMonths();
			$ffeReplacementCostRateForFFE = $ffeItem->getReplacementCostRate()  ;
			$ffeReplacementIntervalInMonthsForFFE = $ffeItem->getReplacementIntervalInMonths();
			$totalCost = $ffeItem->getTotalCost();
			$fixedAssetItemPurchaseDates = $ffeItem->getPurchaseDates($dateIndexWithDate);
			foreach($fixedAssetItemPurchaseDates as $purchaseDateAsIndex => $purchaseDateAsString){
				$transferredAmount = $ffeItem->getMonthlyAmountAtMonthIndex($purchaseDateAsIndex);
			$ffeItemTransferredAmount = $totalItemsCost ? $transferredAmount*($totalCost / $totalItemsCost) : 0  ;
			$projectUnderProgressForFFE = [
				'purchase_date_and_vales'=>[
					$purchaseDateAsIndex =>  $ffeItemTransferredAmount,
				]
			];
			$assets[$ffeItem->getId()][$purchaseDateAsIndex] = $this->calculateFFEAssets($operationStartDateAsIndex,$depreciationDurationInMonthsForFFE,$ffeReplacementCostRateForFFE,$ffeReplacementIntervalInMonthsForFFE,$projectUnderProgressForFFE,$studyDates,$studyEndDateAsIndex);
		
			}
			
			});
		
		return $assets ;
	  
	}
	public function calculateFFEAssets(int $operationStartDateAsIndex,int $propertyDepreciationDurationInMonths,float $propertyReplacementCostRate,int $propertyReplacementIntervalInMonths,array $projectUnderProgressForConstruction,array $studyDates,int $studyEndDateAsIndex ):array 
	{
		$buildingAssets = [];
		// $hospitalitySector = $this->hospitalitySector?:$hospitalitySector;
		// $operationStartDateFormatted = $study->getOperationStartDateFormatted();
		$propertyReplacementCostRate = $propertyReplacementCostRate /100;
		$purchaseDateAsStringAndValue = $projectUnderProgressForConstruction['purchase_date_and_vales']??[];
		$purchaseDateAsIndex = array_key_last($purchaseDateAsStringAndValue);
		// $constructionTransferredDate = array_key_last($constructionTransferredDateAndValue);
		$constructionTransferredValue = $purchaseDateAsStringAndValue[$purchaseDateAsIndex]??0;

		$beginningBalance = 0;
		$totalMonthlyDepreciation = [];
		$accumulatedDepreciation = [];
		$replacementDates = $this->calculateReplacementDates($studyDates,$operationStartDateAsIndex ,$studyEndDateAsIndex,$propertyReplacementIntervalInMonths);
		$depreciation = [];
		$index = 0 ;
		$depreciationStartDateAsIndex = null;
		
		foreach ($studyDates as  $dateAsIndex) {
			if($purchaseDateAsIndex < $operationStartDateAsIndex){
			// if(Carbon::make($constructionTransferredDate)->lessThan($operationStartDateAsIndex)){
				$depreciationStartDateAsIndex = $operationStartDateAsIndex;
		}else{
				$depreciationStartDateAsIndex =$dateAsIndex+1;
				//  getNextDate($studyDates,$dateAsString);
			}
			$depreciationEndDateAsIndex = $depreciationStartDateAsIndex ? $depreciationStartDateAsIndex+$propertyDepreciationDurationInMonths - 1 : null;
			$buildingAssets['beginning_balance'][$dateAsIndex]= $beginningBalance;
			$buildingAssets['additions'][$dateAsIndex]=  $dateAsIndex ==$purchaseDateAsIndex ? $constructionTransferredValue : 0;
			// $buildingAssets['additions'][$dateAsString]=  $dateAsString ==$constructionTransferredDate ? $constructionTransferredValue : 0;
			// $buildingAssets['initial_total_gross'][$dateAsString] =    $beginningBalance;
			$buildingAssets['initial_total_gross'][$dateAsIndex] =  $buildingAssets['additions'][$dateAsIndex] +  $beginningBalance;
			$currentInitialTotalGross = $buildingAssets['initial_total_gross'][$dateAsIndex] ??0;
			$replacementCost[$dateAsIndex] =    in_array($dateAsIndex ,$replacementDates)  ? $this->calculateReplacementCost($currentInitialTotalGross,$propertyReplacementCostRate) : 0;
			if( in_array($dateAsIndex ,$replacementDates) 
			// && ( Carbon::make($constructionTransferredDate)->lessThan($operationStartDateFormatted))
		){
				$depreciationStartDateAsIndex = $dateAsIndex+1;
				$depreciationEndDateAsIndex = $depreciationStartDateAsIndex ? $depreciationStartDateAsIndex+$propertyDepreciationDurationInMonths - 1 : null;
			}
			$replacementValueAtCurrentDate = $replacementCost[$dateAsIndex] ?? 0;
		
			$buildingAssets['replacement_cost'][$dateAsIndex] = $replacementCost[$dateAsIndex] ;
			$buildingAssets['final_total_gross'][$dateAsIndex] = $buildingAssets['initial_total_gross'][$dateAsIndex]  + $replacementValueAtCurrentDate;
			$depreciation[$dateAsIndex]=$this->calculateMonthlyDepreciation($buildingAssets['additions'][$dateAsIndex]??0,$replacementValueAtCurrentDate,$propertyDepreciationDurationInMonths, $depreciationStartDateAsIndex, $depreciationEndDateAsIndex, $totalMonthlyDepreciation, $accumulatedDepreciation,$studyDates);
			$accumulatedDepreciation = $this->calculateAccumulatedDepreciation($totalMonthlyDepreciation,$studyDates);
			$buildingAssets['total_monthly_depreciation'] =$totalMonthlyDepreciation;
			$buildingAssets['accumulated_depreciation'] =$accumulatedDepreciation;
			$currentAccumulatedDepreciation = $buildingAssets['accumulated_depreciation'][$dateAsIndex] ?? 0;
			$buildingAssets['end_balance'][$dateAsIndex] =  $buildingAssets['final_total_gross'][$dateAsIndex] -  $currentAccumulatedDepreciation;
			$beginningBalance = $buildingAssets['final_total_gross'][$dateAsIndex];
			$index++;
		}
		
		return $buildingAssets ;
	}
	protected function calculateMonthlyDepreciation(float $additions,float $replacementCost,int $propertyDepreciationDurationInMonths, ?int $depreciationStartDateAsIndex, ?int $depreciationEndDateAsIndex, &$totalMonthlyDepreciation, &$accumulatedDepreciation,array $studyDates)
	{
		if (is_null($depreciationStartDateAsIndex) || is_null($depreciationEndDateAsIndex)) {
			return [];
		}
		$monthlyDepreciations = [];
		$monthlyDepreciationAtCurrentDate =  ($additions+$replacementCost) / $propertyDepreciationDurationInMonths ;
		$depreciationDates = generateDatesBetweenTwoIndexedDates($depreciationStartDateAsIndex,$depreciationEndDateAsIndex);
		// $depreciationStartDateAsCarbon = Carbon::make($depreciationStartDate);
		// $depreciationEndDateAsCarbon = Carbon::make($depreciationEndDate);
		// $depreciationDates = generateDatesBetweenTwoDates($depreciationStartDateAsCarbon, $depreciationEndDateAsCarbon, 'addMonth', 'Y-m-d');
		foreach ($studyDates as  $dateAsIndex) {
			$previousDateAsIndex = $dateAsIndex-1;
			if(in_array($dateAsIndex,$depreciationDates)){
				$monthlyDepreciations[$dateAsIndex] = $monthlyDepreciationAtCurrentDate;
				$totalMonthlyDepreciation[$dateAsIndex] = isset($totalMonthlyDepreciation[$dateAsIndex]) ? $totalMonthlyDepreciation[$dateAsIndex] +$monthlyDepreciationAtCurrentDate : $monthlyDepreciationAtCurrentDate;
				$accumulatedDepreciation[$dateAsIndex] = $previousDateAsIndex>=0 ? ($totalMonthlyDepreciation[$dateAsIndex] + $accumulatedDepreciation[$previousDateAsIndex]) : $totalMonthlyDepreciation[$dateAsIndex];
			}else{
				// $monthlyDepreciations[$dateAsString] = 0;
				// $totalMonthlyDepreciation[$dateAsString]  = 0 ;
				$accumulatedDepreciation[$dateAsIndex] = $accumulatedDepreciation[$previousDateAsIndex] ?? 0 ;
			}
		}

		return $monthlyDepreciations;
	}
	protected function calculateAccumulatedDepreciation(array $totalMonthlyDepreciation,array $studyDates)
	{
		$result = [];
		foreach ($studyDates  as $date=>$dateIndex) {
			$value = $totalMonthlyDepreciation[$dateIndex] ?? 0; 
			$previousDate = $dateIndex -1 ;
			$result[$dateIndex] = $previousDate >=0 ? $result[$previousDate] + $value : $value;
		}

		return $result;
	}
	protected function calculateReplacementCost(float $totalGross, float $propertyReplacementCostRate  )
	{
		return $totalGross * $propertyReplacementCostRate ;
	}
	protected function calculateReplacementDates(array $studyDates , int $operationStartDateAsIndex , int $studyEndDateAsIndex ,int $propertyReplacementIntervalInMonths)
	{
		$replacementDates = [];
		foreach($studyDates as $studyDateAsIndex){
			if($operationStartDateAsIndex > $studyEndDateAsIndex){
				break ;	
			}
			$replacementDates[$studyDateAsIndex] = $operationStartDateAsIndex+$propertyReplacementIntervalInMonths;
			$operationStartDateAsIndex = $replacementDates[$studyDateAsIndex] ;
		}
		return $replacementDates ;
	}	
	
	
	
}
