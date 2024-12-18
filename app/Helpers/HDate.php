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
	public static function allDatesGreaterThanOrEqual(array $dates , ?string $checkDate = null)
	{
		if(is_null($checkDate)){
			return false ;
		}
		foreach($dates as $date){
			$currentDate = Carbon::make($date) ;
			if(is_null($currentDate)){
				return false ;
			}
			$lessThan = $currentDate->lessThan(Carbon::make($checkDate));
			if($lessThan){
				return false ;
			}
		}
		return true ;
	}
	public static function generateStartDateAndEndDateBetween(string $startDate , string $endDate):array{
		
		$result  = [];
		$dates = generateDatesBetweenTwoDates(Carbon::make($startDate),Carbon::make($endDate));
		$currentStartDate = null;
		foreach($dates as $startDate){
			$startDate = $currentStartDate ?: $startDate;
			$endDateOfCurrentMonth = Carbon::make($startDate)->endOfMonth()->format('Y-m-d');
			if(Carbon::make($endDateOfCurrentMonth)->greaterThan(Carbon::make($endDate))){
				$endDateOfCurrentMonth = $endDate ;
			}
			$result[] = ['start_date'=>$startDate,'end_date'=>$endDateOfCurrentMonth];
			$currentStartDate = Carbon::make($endDateOfCurrentMonth)->addDay()->format('Y-m-d');
		}
		return $result;
		
	}
	public static function generateEndOfMonthsDatesBetweenTwoDates(Carbon $startDate , Carbon $endDate)
	{
		$startDate = $startDate->endOfMonth();
		$endDate = $endDate->endOfMonth();
		$currentDate = $startDate;
		$intervalDates = [
			$currentDate->format('Y-m-d')
		];
		
		while ($endDate->greaterThan($currentDate)){
			$intervalDates[] = $currentDate->addMonthWithNoOverflow()->endOfMonth()->format('Y-m-d');
		}
		return $intervalDates;

	}
	
	
}
