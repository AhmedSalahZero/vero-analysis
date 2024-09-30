<?php

namespace App\Helpers;

use Carbon\Carbon;
use Exception;

class HArr
{
	public static function sumAtDates(array $items, array $dates)
	{
		$itemsCount = count($items);
		if (!$itemsCount) {
			return [];
		}
		if (!isset($items[0])) {
			throw new Exception('Custom Exception .. First Parameter Must Be Indexes Array That Contains Arrays like [ [] , [] , [] ]');
		}

		$total = [];
		foreach ($dates as $date) {
			$currenTotal = 0;
			for ($i = 0; $i< $itemsCount; $i++) {
				$currenTotal+=$items[$i][$date]??0;
			}
			$total[$date] = $currenTotal;
		}

		return $total;
	}

	public static function subtractAtDates(array $items, array $dates)
	{
		$itemsCount = count($items);
		if (!$itemsCount) {
			return [];
		}
		if (!isset($items[0])) {
			throw new Exception('Custom Exception .. First Parameter Must Be Indexes Array That Contains Arrays like [ [] , [] , [] ]');
		}

		$total = [];
		foreach ($dates as $date) {
			$currenTotal = 0;
			for ($i = 0; $i< $itemsCount; $i++) {
				if ($i == 0) {
					$currenTotal += $items[$i][$date]??0;
				} else {
					$currenTotal -= $items[$i][$date]??0;
				}
			}
			$total[$date] = $currenTotal;
		}

		return $total;
	}

	public static function fillMissedKeysFromPreviousKeys(array $items, array $dates, $defaultValue = 0)
	{
		$previousValue = $defaultValue;
		$newItems = [];
		foreach ($dates as $date) {
			if (isset($items[$date])) {
				$previousValue = $items[$date];
				$newItems[$date] = $items[$date];
			} else {
				$newItems[$date] = $previousValue;
			}
		}

		return $newItems;
	}

	public static function accumulateArray(array $items)
	{
		$result =[];
		$finalResult =[];
		$index = 0;
		foreach ($items as $date=>$value) {
			$previousValue = $result[$index-1] ??0;
			$currentVal = $previousValue + $value;
			$result[$index] = $currentVal;
			$finalResult[$date] = $currentVal;
			$index++;
		}

		return $finalResult;
	}
	public static function MultiplyWithNumber(array $items , float $number)
	{
		$newItems = [];
		foreach($items as $key=>$value){
			$newItems[$key]=$value * $number ;
		}
		return $newItems ;
	}

	public static function getIndexesBeforeDateOrNumericIndex(array $items, string $index, $indexIsDate = true)
	{
		$result = [];
		foreach ($items as $date => $value) {
			if ($indexIsDate ? Carbon::make($date)->lessThan(Carbon::make($index)) : $date < $index) {
				$result[$date]=$value;
			}
		}

		return $result;
	}
	public static  function sortBasedOnKey(array $arr, string $key):array 
	{
		usort($arr, function ($a, $b) use($key) {
			return strtotime($a[$key]) - strtotime($b[$key]); 
			// return (int)Carbon::make($a[$key])->greaterThan(Carbon::make($b[$key]));
		});
		return $arr ;
	}
	public static function removeKeyFromArrayByValue(array $items , array $valuesToRemove){
		foreach($valuesToRemove as $valueToRemove){
			$found = array_search($valueToRemove , $items);
			if($found !== false){
				unset($items[$found]);
			}
		}
		return array_values($items) ; 
	}
	public static function removeNullValues(array $items){
		$result = [];
		foreach($items as $key => $val){
			if(!trim($val)){
				continue ;
			}
			$result[$key] = $val ;
		}	
		return $result ;
	}
	/**
	 * get only items that has keys 
	 */
	public static function filterByKeys(array $items , array $keys){
		$newItems = [];
		foreach($items as $key => $value){
			if(in_array($key , $keys)){
				$newItems[$key] = $value ;
			}
		}
		return $newItems ;
	}
	public static function removeKeysFromArray(array $items , array $keysToBeRemoved){
		$result = [];
		foreach($items as $currentKey => $value){
			if(!in_array($currentKey,$keysToBeRemoved)){
				$result[$currentKey] = $value ;
			}
		}
		return $result; 
	}
	public static function filterTrulyValue(array $arr):array 
	{
		return array_filter($arr,function($value){
			return $value ;
		});
	}
	public static function atLeastOneValueExistInArray(array $items , array $itemsToSearchIn){
		foreach($items as $item){
			if(in_array($item,$itemsToSearchIn)){
				return true  ;
			}
		}
		return false ;
	}
	public static function unformatValues(array $items )
	{
		$result = [];
		foreach($items as $key=>$value){
			$result[$key] = unformat_number($value); 
		}
		return $result;
	}
}
