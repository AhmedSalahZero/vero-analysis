<?php 
namespace App\Helpers;

use Carbon\Carbon;

class HDate 
{
	public static function formatDateFromDatePicker(?string $date):?string
	{
		$originDate = $date;
		if(!$date){
			return null ;
		}
		$date = explode('/',$date);
		if(isset($date[1])){
			return $date[2] .'-'.$date[1] . '-'.$date[0];
		}
		return $originDate ;
	}	
	public static function generateUniqueDateTimeForModel(string $fullClassName , string $columnName , string $dateTime , array $additionalConditions)
	{
		return self::searchForUnique($fullClassName  , $columnName , $dateTime , $additionalConditions);
	}
	public static function searchForUnique(string $fullClassName , string $columnName , string $dateTime , array $additionalConditions)
	{
		$query = $fullClassName::where($columnName,$dateTime);
		foreach($additionalConditions as $condition){
			$additionalColumnName = $condition[0];
			$operation = $condition[1];
			$value = $condition[2];
			$query->where($additionalColumnName,$operation,$value);
		}
		$isExist = $query->exists() ;
		if($isExist){
			$dateTime = Carbon::make($dateTime)->addSecond()->format('Y-m-d H:i:s');
			return self::searchForUnique($fullClassName  , $columnName , $dateTime , $additionalConditions);
		}
		return $dateTime;
	}
}
